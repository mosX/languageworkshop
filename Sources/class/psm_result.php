<?php
class Psm_result{
    private $m;

    public function __construct(mainframe & $mainframe){
        $this->m =  $mainframe;
    }

    public function HandleResultRequest(){
        // START *** SorexPay Callback Delivery Service
        if ($_SERVER["HTTP_USER_AGENT"] == 'SorexPay Callback Delivery Service') {
            $this->debug_paysystem_server_response("/home/24boption/logs/inresponse/sp/");

            $ch = curl_init("http://85.10.207.7/server_response/sorexpay/");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 25);
            curl_exec($ch);
            curl_close($ch);
            die();
        }
        // END *** SorexPay Callback Delivery Service

        $PARAMS["signature"] = trim(getParam($_POST, "signature", ""));
        $PARAMS["operation_xml"] = trim(getParam($_POST, "operation_xml", ""));

        if ("" == $PARAMS["signature"] || "" == $PARAMS["operation_xml"]) {
            return $this->On_Request_Fail($PARAMS, 'INVALID_REQUEST');
        }

        $xml_decoded = base64_decode($PARAMS["operation_xml"]); // разшифровываем полученые данные
        if (FALSE === $xml_decoded) {
            return $this->On_Request_Fail($PARAMS, 'INVALID_REQUEST');
        }

        $xml = simplexml_load_string($xml_decoded); // парсим xml
        if (FALSE === $xml) {
            return $this->On_Request_Fail($PARAMS, 'INVALID_REQUEST');
        }

        $merchantId = $this->m->config->merchantId;
        $merchantSign = $this->m->config->merchantSign;

        if (trim(getParam($_GET, "ver", "")) == 'mobile') {
            $merchantId = $this->m->config->merchantIdMobile;
            $merchantSign = $this->m->config->merchantSignMobile;
        }

        $sign = base64_encode(sha1($merchantSign . $xml_decoded . $merchantSign, 1));

        if ($sign != $PARAMS["signature"]) {
            return $this->On_Request_Fail($PARAMS, 'INVALID_HASH');
        }

        $PARAMS = array_merge($PARAMS, json_decode(json_encode($xml),TRUE));

        if ($PARAMS["merchant_id"] != $merchantId) {
            return $this->On_Request_Fail($PARAMS, 'INVALID_MERCHANT');
        }

        $PARAMS["merchant_order_id"] = intval($PARAMS["merchant_order_id"]);
        $PARAMS["amount"] *= 100;
        $PARAMS["fee"]    *= 100;

        // Call handlers
        if ($PARAMS["status"] > 0) {
            $this->On_Payment_Success($PARAMS);
            exit('OK');
        } else {
            $this->On_Payment_Cancel($PARAMS);
            exit('OK');
        }
    }
    //------------------------------------------------------------------------------
    //
    public function On_Request_Fail($params, $code){
        exit('FAIL');
    }
    //------------------------------------------------------------------------------
    //
    public function On_Payment_Success(&$PARAMS)
    {
//        @file_put_contents($this->m->config->basepath . '../../psm_logs/'. $PARAMS["order_id"] .'.txt',
//            date('d.m.Y H:i:s') . " SUCCESS\n"
//            .'PARAMS: '.print_r($PARAMS, true),
//            FILE_APPEND
//        );

        if (strpos($_SERVER["REMOTE_ADDR"], "85.10.207.7") === FALSE)
            exit('FAIL');

        $this->m->_db->setQuery(        //получаем попытку депозита
              " SELECT * "
            . " FROM `deposits` "
            . " WHERE `id` = " . $this->m->_db->Quote($PARAMS["order_id"])
            . " AND `status` = 0"
            . " LIMIT 1;"
            );
        $this->m->_db->loadObject($deposit);

        if (!$deposit)
            exit('FAIL');

        if ($PARAMS["merchant_order_id"] == $deposit->transaction_id)
            exit('FAIL');

        $userid = $deposit->user_id;
        $account_id = $deposit->account_id;

        if (empty($userid) || empty($account_id))
            exit('FAIL');

        $this->m->_db->setQuery(
            " SELECT `users`.`id`"
            . " , `users`.`email`"
            . " , `users`.`status` "
            . " , `users`.`country` "
            . " , `users`.`demo_expire` "
            . " FROM `users` "
            . " WHERE `users`.`id` = " . $this->m->_db->Quote($userid)
            . " LIMIT 1;"
            );
        $this->m->_db->loadObject($user);

        if (!is_object($user) || $user->id <= 0)
            exit('FAIL');

        if (empty($PARAMS["merchant_order_id"]))
            exit('FAIL');

        //получаем его акаунты и проверяем или вобще есть
        $this->m->_db->setQuery(
            "SELECT * "
            . " FROM `accounts` "
            . " WHERE `user_id` = " . $this->m->_db->Quote($user->id)
            . " AND `mode` > 0"
            . " AND `id` = " . $this->m->_db->Quote($account_id)
            . " LIMIT 1"
            );
        $this->m->_db->loadObject($account);

        if (!is_object($account))
            exit('FAIL');

//        if (!is_object($account) || $account->id <= 0)
//            //добавляем страницы со счетами
//            $account->user_id = $user->id;
//            $account->currency = "USD";
//            $account->minbet = 1000;
//            $account->status = 1;
//            $account->balance = 0;
//            $account->mode = 1;
//            $this->m->_db->insertObject('accounts', $account);
//            $account->id = $this->m->_db->insertid();
//        }

        $amount = $PARAMS["amount"];    //сумма депозита

        $deposits_sum = $account->deposit_sum + $amount;
        $withdraw_sum = $account->withdraw_sum + $amount;

        $deposit->start_balance = $account->balance;
        $deposit->end_balance = $account->balance + $amount;
        $deposit->amount = $amount;
        $deposit->transaction_id = $PARAMS["merchant_order_id"];
        $deposit->paysystem_id = strtoupper($PARAMS['system']);
        $deposit->paysystem_account = $PARAMS['purse'];
        $deposit->description = print_r($PARAMS, true);
        $deposit->fee = $PARAMS['fee'];
        $deposit->status = 1;
        $deposit->result = "PSM";

        if (in_array($deposit->paysystem_id, array("YM","QIWI","MM","RBK","ZP","W1","UK","WC","MVC-IK","LP-IK","ALFACLICK","SBERONLINE")))
            $deposit->result = "IK";

        if (!empty($deposit->paysystem_account)) {
            $this->m->_db->setQuery(
                    " SELECT `user_id` "
                    . " FROM `withdraws` "
                    . " WHERE `paysystem_account` = " . $this->m->_db->Quote($deposit->paysystem_account)
                    . " AND `result` = 'ok' "
                    . " LIMIT 1;"
                    );
            if ((int)$this->m->_db->loadResult())
                $deposit->iswithdrawal = 1;
        }

//        if(!$this->m->_db->updateObject('deposits', $deposit, 'id'))
//            exit('FAIL');

        /************************BONUS*****************************/
        $give_bonus = (int)$PARAMS["bonus"];
        $bonus_sum = 0;

/*        if (in_array($this->m->_user->country, array('112','113','138')) && $amount < 5000) {
            $give_bonus = 0;
        } elseif (!in_array($this->m->_user->country, array('112','113','138')) && $amount < 10000){
            $give_bonus = 0;
        }*/

        if ($give_bonus >= 1000) {
            $this->m->_db->setQuery(
                "SELECT `promocodes`.* "
                . " FROM `promocodes` "
                . " WHERE `promocodes`.`id` = " . $this->m->_db->Quote($give_bonus)
                . " LIMIT 1"
                );
            $code = $this->m->_db->loadObjectList();
            $code = reset($code);

            //TODO
            if($code && $code->mindeposit <= $amount){
                $bonus_sum = ($amount/100) * $code->amount;

                $bonus->user_id = $user->id;
                $bonus->bonus_id = 4;
                $bonus->wager = $code->wager;
                $bonus->deposit_id = $deposit->id;
                $bonus->amount = $bonus_sum;
                $bonus->total_bet = ($bonus_sum + $amount) * $code->wager;
                $bonus->start_balance = $deposit->end_balance;
                $bonus->end_balance = $deposit->end_balance + $bonus_sum;
                $bonus->bet = 0;
                $bonus->status = 1;

                //$this->m->_db->insertObject('user_bonus', $bonus);
            }
        } else {  //в другой ситуации узнаем что єто за бонус и добавляем его
           /* $this->m->_db->setQuery(
                        "SELECT `bonuses`.* "
                        . " FROM `bonuses` "
                        . " WHERE `bonuses`.`id` = " . $give_bonus
                        . " AND `bonuses`.`status` = 1"
                        . " LIMIT 1"
                    );
            $bonus = $this->m->_db->loadObjectList();
            $bonus = reset($bonus);

            if($bonus){
                $bonus_sum = ($amount/100)*$bonus->amount;

                $bonus->user_id = $user->id;
                $bonus->bonus_id = $bonus->id;
                $bonus->wager = $bonus->wager;
                $bonus->deposit_id = $deposit->id;
                $bonus->amount = $bonus_sum;
                $bonus->total_bet = $bonus_sum * $bonus->wager;
                $bonus->start_balance = $deposit->end_balance;
                $bonus->end_balance = $deposit->end_balance + $bonus_sum;
                $bonus->bet = 0;
                $bonus->status = 1;

                $this->m->_db->insertObject('user_bonus',$row);
            }*/
        }
        /*****************************************************/

        $maxBalance = ($amount + $bonus_sum) * (2 + mt_rand(0,100)/100) + $deposit->start_balance;

        $account->balance = $deposit->end_balance + $bonus_sum;
        $account->maxbalance = $maxBalance;
        //$accounts->minbet = $amount < 10000 ? 100 : 1000;
        $account->deposit_sum = $deposits_sum;

        $demo_expire = 0;

        xload("class.lib.ws.Client");

        try {
            $packet = new stdClass;
            $packet->name = "deposit";
            $packet->account_id = $account->id;
            $packet->maxbalance = $account->maxbalance;

            $packet->deposit = new stdClass;
            $packet->deposit->id = $deposit->id;
            $packet->deposit->amount = $deposit->amount;
            $packet->deposit->fee = $deposit->fee;
            $packet->deposit->transaction_id = $deposit->transaction_id;
            $packet->deposit->paysystem_account = is_string($deposit->paysystem_account) ? $deposit->paysystem_account : "";
            $packet->deposit->description = $deposit->description;
            $packet->deposit->result = $deposit->result;
            $packet->deposit->iswithdrawal = $deposit->iswithdrawal;

            if ($bonus_sum) {
                $packet->bonus = new stdClass;
                $packet->bonus->bonus_id = $bonus->bonus_id;
                $packet->bonus->wager = $bonus->wager;
                $packet->bonus->amount = $bonus->amount;
                $packet->bonus->total_bet = $bonus->total_bet;
            } else {
                $packet->bonus = null;
            }

            $ws = new WebSocket\Client($this->m->config->serverWS, array('timeout' => 10));

            $ws->send(json_encode($packet));

            $response = json_decode($ws->receive());

            if ($response[0]->status != "ok")
                exit('FAIL [WS RESPONSE]');
        } catch(Exception $e) {
            if (!$this->m->_db->updateObject('deposits', $deposit, 'id'))
                exit('FAIL');

            if ($bonus_sum)
                $this->m->_db->insertObject('user_bonus', $bonus);

            if (!$this->m->_db->updateObject('accounts', $account, 'id'))
                exit('FAIL');

            $demo_expire = time() + 86400; //86400 - 1 day
            if ($amount >= 25000 && $amount < 50000) {
                $demo_expire = time() + 5 * 86400;
            } else if ($amount >= 50000 && $amount < 100000) {
                $demo_expire = time() + 14 * 86400;
            } else if ($amount >= 100000) {
                $demo_expire = time() + 30 * 86400;
            }

            if (strtotime($user->demo_expire) > $demo_expire) {
                $demo_expire = 0;
            }
        }

        //считаем новый лвл пользователя
        $level = 0;
        if ($deposits_sum >= 25000 &&  $deposits_sum < 50000) {
            $level = 1;
        } else if($deposits_sum >= 50000 &&  $deposits_sum < 100000) {
            $level = 2;
        } else if($deposits_sum >= 100000 &&  $deposits_sum < 300000) {
            $level = 3;
        } else if($deposits_sum >= 300000 &&  $deposits_sum < 500000) {
            $level = 4;
        } else if($deposits_sum >= 500000 &&  $deposits_sum < 700000) {
            $level = 5;
        } else if($deposits_sum >= 700000 &&  $deposits_sum < 1000000) {
            $level = 6;
        } else if($deposits_sum >= 1000000 &&  $deposits_sum < 2500000) {
            $level = 7;
        } else if($deposits_sum >= 2500000 &&  $deposits_sum < 5000000) {
            $level = 8;
        } else if($deposits_sum >= 5000000 &&  $deposits_sum < 10000000) {
            $level = 9;
        } else if($deposits_sum >= 10000000) {
            $level = 10;
        }

        $this->m->_db->setQuery(
            " UPDATE `users` SET"
            . " `level` = " . $this->m->_db->Quote($level)
            . ($demo_expire ? " , `demo_expire` = " . $this->m->_db->Quote(date("Y-m-d H:i:s", $demo_expire)) : "")
            . " ,`verified` = 1"
            . " WHERE `id` = " . $this->m->_db->Quote($user->id)
            . " LIMIT 1;"
            );
        $this->m->_db->query();

        if (3 == $user->status || 4 == $user->status) {
            $message = "BL-M";
        } else {
            if (!empty($deposit->paysystem_account)) {
                if (1 == $deposit->iswithdrawal) {
                    $message = "BL-W";
                } else {
                    $this->m->_db->setQuery(
                            " SELECT `deposits`.`user_id` "
                            . " FROM `deposits` "
                            . " WHERE `deposits`.`paysystem_account` = " . $this->m->_db->Quote($deposit->paysystem_account)
                            . " AND `deposits`.`id` != " . $this->m->_db->Quote($deposit->id)
                            . " AND `deposits`.`status` = 1"
                            . " LIMIT 1;"
                            );

                    if ((int)$this->m->_db->loadResult()) {
                        $message = "BL-D";
                    }
//                    else {
//                        $this->m->_db->setQuery(
//                                " SELECT `history`.`ip` "
//                                . " FROM `history` "
//                                . " WHERE `history`.`action` = '' "
//                                . " AND `history`.`user_id` = " . $this->m->_db->Quote($user->id)
//                                . " GROUP BY `history`.`ip` "
//                        );
//                        $ips = $this->m->_db->loadResultArray(0);
//                        for ($i = 0, $count_ips = count($ips); $i < $count_ips; $i++) {
//                            $search_ip = substr($ips[$i], 0, strrpos($ips[$i], '.') + 1);
//                            $this->m->_db->setQuery(
//                                    " SELECT `history`.`id` "
//                                    . " FROM `history` "
//                                    . " LEFT JOIN `users` ON `history`.`user_id` = `users`.`id` "
//                                    . " LEFT JOIN `club` ON `users`.`club_id` = `club`.`id` "
//                                    . " WHERE `history`.`ip` LIKE " . $this->m->_db->Quote($search_ip . "%")
//                                    . " AND `history`.`action` = '' "
//                                    . " AND `history`.`user_id` != " . $this->m->_db->Quote($user->id)
//                                    . " AND `users`.`status` > 1 "
//                                    . " AND `users`.`club_id` >= " . $this->m->config->club_id_start
//                                    . " AND `users`.`club_id` <= " . $this->m->config->club_id_end
//                                    . " AND `club`.`gid` = 1 "
//                                    . " LIMIT 1;"
//                            );
//                            if ((int)$this->m->_db->loadResult()) {
//                                $message = "BL-IP";
//                                break;
//                            }
//                        }
//                    }
                }
            }
        }

//        if ("MVC" == $deposit->paysystem_id) {
//            $mailbody_html = "<p>Dear player " . $user->username . ".</p>\r\n"
//                           . "<p>Your " . htmlentities($PARAMS['coupon']) . " coupon has been activated on amount of " . number($amount) . " PSM USD and credited to the personal account.</p>\r\n"
//                           . "<p>You can write to customer support on any interested questions at: " . $this->m->config->email . "</p>\r\n"
//                           . "<p>Sincerely, Administration.</p>\r\n"
//                           ;
//
//            sendemail($user->email, "=?UTF-8?B?" . base64_encode('Notice of add funds to the personal account.') . "?=", $mailbody_html, "", "noreply@" . $_SERVER["SERVER_NAME"]);
//        }

        $ch = curl_init("http://binobot.ru/messages/psm/");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array("amount" => $deposit->amount, "user_id" => $deposit->user_id, "balance" => $account->balance));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_exec($ch);
        curl_close($ch);

        $message = "24B " . $user->id . " " . (isset($message) ? "(" . $message . ")" : "") . "     \r\n"
                 . ($amount / 100) . " " . $PARAMS['system']
//                 . ($bonus_sum ? "\r\n+ bonus    " . ($bonus_sum / 100) : "")
                 . "\r\n    MAX " . ($maxBalance / 100)
                 ;

        $to = array(
            "osivinyuk@gmail.com",
            "lyolik1@gmail.com",
            "9897084@gmail.com"
            );

        send_jabber_msg($to, $message);

        exec_in_bg("/home/24boption/tocrm.php -d" . $deposit->id);
    }

    //------------------------------------------------------------------------------
    //
    public function On_Payment_Cancel($PARAMS)
    {
//        @file_put_contents($this->m->config->basepath . '../../psm_logs/'. $PARAMS["order_id"] .'.txt',
//            date('d.m.Y H:i:s') . " CANCEL\n"
//            .'PARAMS: '.print_r($PARAMS, true),
//            FILE_APPEND
//        );
    }

    private function debug_paysystem_server_response($path) {
        list($usec, $sec) = explode(" ", microtime());

        @file_put_contents($path . date("d.M.Y_H.i.s") . "." . $usec . ".txt",
             "=== Time: " . date("H:i:s, d M (l)") . " ===\r\n_SERVER\r\n" . var_export($_SERVER, true)
            . "\r\n\r\n_POST\r\n" . var_export($_POST, true)
            . (isset($_POST["response"]) ? "\r\n\r\n_POST[response]\r\n" . str_replace("><", ">\r\n<", base64_decode($_POST["response"])) . "\r\n" : "")
            . "\r\n===============================================\r\n",
            FILE_APPEND
            );
    }

}
?>