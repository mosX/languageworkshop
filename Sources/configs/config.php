<?php        
$config = array(
    "host" => "localhost",
    "user" => "root",
    "pass" => "killer1906",
    "db"   => "languageworkshop",
    
//    'assets_source' => 'http://newsmarttv.com/assets',
    'assets_source' => 'http://smarttv.probud.net.ua/assets',

    'auth_server' => 'http://195.88.159.227:5500/',

    'serverWS' => 'ws://ws.lotostrade.com:7777',
    
    "facebookAppId" => '249716208558248',
    "facebookAppSecret" => '4d43bc64a2368a0d0615c6c242516ec7',
    
    "email" => "support@platinumbin.com",
    "sendername" => "PlatinumBin",
    "smtp_host"  => "localhost",

    "xmpp" => array(
        "host" => "jabbim.com",//"jabme.eu"
        "port" => 5222,
        "user" => "informer",
        "password" => "xmpp jaber password-2016",//"xmpp jaber password-2013"
        "server" => "jabbim.com"//"jabme.eu"
        ),

    "filesize" => 2 * 1024 * 1024,
    
    "betlist" => array(10,20,50,100,250,500,1000),

    "auth_errors" => array(
        'login-incorrect'=> _("Wrong password or login"),
        'login-blocked' => _("Your account blocked, contact our support team"),
        'demologin'=> _("Probably you wanted to enter a Demo mode"),
        'reallogin'=> _("Probably you wanted to enter a Real mode"),
        'failedlogin' => _("Your account blocked, contact our support team")
    ),
    
    "paySystemsFullName" => array(
        "cc" => 'Visa,MasterCard',
        "card-sp" => 'Visa,MasterCard',
        "card-ym" => 'Visa,MasterCard',
        "webmoney" => 'WebMoney',
        "liqpay" => 'LiqPay',
        "libertyreserve" => 'LibertyReserved',
        "perfectmoney" => 'PerfectMoney',
        "moneymail" => 'MoneyMail',
        "rbkmoney" => 'RBKMoney',
        "zpayment" => 'ZPayment',
        "w1" => 'WalletOne',
        "qiwi" => 'QIWI',
        "neteller" => 'NETELLER',
        "yandexmoney" => 'Yandex.Money',
        "webcreds" => 'WebCreds',
        "alfaclick" => 'AlfaClick',
        "sberonline" => 'Sberbank'
    ),
    
     "paymentParams" => array(  //100
                "cc" => array("MVC", "min" => 250, "max" => 5000),
                "webmoney" => array("WM", "min" => 250, "max" => 5000),
                "liqpay" => array("LP", "min" => 250, "max" => 5000),
                "libertyreserve" => array("LR", "min" => 250, "max" => 5000),
                "perfectmoney" => array("PM", "min" => 250, "max" => 5000),
                "moneymail" => array("MM", "min" => 250, "max" => 5000),
                "rbkmoney" => array("RBK", "min" => 250, "max" => 5000),
                "zpayment" => array("ZP", "min" => 250, "max" => 5000),
                "w1" => array("W1", "min" => 250, "max" => 5000),
                "qiwi" => array("QIWI", "min" => 200, "max" => 200),
                "neteller" => array("NETELLER", "min" => 250, "max" => 5000),
                "yandexmoney" => array("YM", "min" => 250, "max" => 5000),
                "webcreds" => array("WC", "min" => 250, "max" => 5000),
                "card-ym" => array("MVC-YM", "min" => 250, "max" => 5000),
                "alfaclick" => array("ALFACLICK", "min" => 250, "max" => 5000),
                "sberonline" => array("SBERONLINE", "min" => 250, "max" => 5000),
                "card-sp" => array("MVC-SP", "min" => 250, "max" => 5000)
            ),
   "paymentParams_low" => array(     //50
                "cc" => array("MVC", "min" => 250, "max" => 1000),
                "webmoney" => array("WM", "min" => 250, "max" => 1000),
                "liqpay" => array("LP", "min" => 250, "max" => 1000),
                "libertyreserve" => array("LR", "min" => 250, "max" => 1000),
                "perfectmoney" => array("PM", "min" => 250, "max" => 1000),
                "moneymail" => array("MM", "min" => 250, "max" => 1000),
                "rbkmoney" => array("RBK", "min" => 250, "max" => 1000),
                "zpayment" => array("ZP", "min" => 250, "max" => 1000),
                "w1" => array("W1", "min" => 250, "max" => 1000),
                //"qiwi" => array("QIWI", "min" => 150, "max" => 1000),
                "neteller" => array("NETELLER", "min" => 250, "max" => 10000),
                "yandexmoney" => array("YM", "min" => 250, "max" => 1000),
                "webcreds" => array("WC", "min" => 250, "max" => 1000),
                "card-ym" => array("MVC-YM", "min" => 250, "max" => 1000),
                "alfaclick" => array("ALFACLICK", "min" => 250, "max" => 1000),
                "sberonline" => array("SBERONLINE", "min" => 250, "max" => 1000),
                "card-sp" => array("MVC-SP", "min" => 250, "max" => 1000)
            ),

    //'-11'  => _("-11 Samoa"),
    "timezone" =>array(
        '-11'  => _("-11 Samoa"),
        '-10'  => _("-10 Hawaii"),
        '-9'   => _("-9 Alaska"),
        '-8'   => _("-8 United States and Canada"),
        '-7'   => _("-7 Mexico"),
        '-6'   => _("-6 Central Time (USA & Canada)"),
        '-5'   => _("-5 Eastern Time"),
        '-4'   => _("-4 Atlantic time"),
        '-3.5' => _("-3:30 Newfoundland"),
        '-3'   => _("-3 South American Eastern Time"),
        '-2'   => _("-2 Mid-Atlantic"),
        '-1'   => _("-1 Azores, Cape Verde"),
        '+0'   => _("+0 Western European Time"),
        '+1'   => _("+1 Central European Time"),
        '+2'   => _('+2 Eastern European Time'),
        '+3'   => _('+3 Moscow time'),
        '+3.5' => _('+3:30 Iran'),
        '+4'   => _('+4 Samara time'),
        '+4.5' => _('+4:30 Afghanistan'),
        '+5'   => _('+5 Western Asian time'),
        '+5.5' => _('+5:30 India'),
        '+5.7' => _('+5:45 Nepal'),
        '+6'   => _('+6 Novosibirsk'),
        '+6.5' => _('+6:30 Myanmar'),
        '+7'   => _('+7 Southeast Asia'),
        '+8'   => _('+8 Irkutsk time'),
        '+9'   => _('+9 Yakut time'),
        '+9.5' => _('+9:30 Central Australian time'),
        '+10'  => _("+10 Vladivostok time"),
        '+11'  => _("+11 Magadan time"),
        '+12'  => _("+12 Kamchatka time"),
        '+13'  => _("+13 Tonga"),
        '+14'  => _("+14 Line Islands")
    ),
    
    "paySystems" => array(
        'MVC-IK' => 'Visa/Mastercard',
        'MVC-YM' => 'Visa/Mastercard',
        'MVC-SP' => 'Visa/Mastercard',
        'MVC' => 'Visa/Mastercard',
        'WM' => 'WebMoney',
        'LP' => 'LiqPay',
        'LR' => 'Libertyreserved',
        'PM' => 'PerfectMoney',
        'MM' => 'MoneyMail',
        'RBK' => 'RBKmoney',
        'ZP' => 'Zpayment',
        'W1' => 'WalletOne',
        'QIWI' => 'QIWI',
        'YM' => 'YandexMoney',
        'WC' => 'WebCreds',
        'NETELLER'=>'NETELLER',
        'INT'=>'Internal transfer'
    ),

    "minbet" => 1000,
    "maxbet" => 100000,
    "miniminbet" => 100,
    "minimaxbet" => 100,
    "betlist" => array(10,20,50,100,250,500,1000),
    "minibetlist" => array(1),
    
    "minage" =>18,
    "maxage" =>100,
    
    "minigain" => 32,
    "demogain" => 35,
    "demosmallgain" => 15,
    "sinkgain" => -40,
    "biggain" => -60,
    
    "club_id_start" => 11100401,
    "club_id_end" => 11100499,
    
    "sitename" => 'PlatinumBin',
    "siteurl" => 'platinumbin.com',
    "siteemail" => 'support@platinumbin.com',
    
    "merchantIdMobile" => 2075352,
    "merchantSignMobile" => "T3pVLPhMn245C2VuRMzafQexDemmM8yq",
    
    "merchantId" => 2075352,
    "merchantSign" => "T3pVLPhMn245C2VuRMzafQexDemmM8yq",
    
    'defaultlang' => 'ru',
    'available_languages' => array("en","ar","sv","fi","es","ru","de","pl","hi","pt","zh-chs","da"),
    
    //'quote_str' => 'AUDCAD AUDCHF AUDJPY AUDNZD AUDSGD AUDUSD EURAUD EURCAD EURCHF EURGBP EURGBP EURJPY EURSGD EURUSD GBPAUD GBPCAD GBPCHF GBPJPY GBPSGD GBPUSD NZDCAD NZDCHF NZDJPY NZDUSD USDCAD USDCHF USDDKK USDJPY USDMXN USDNOK USDSEK USDSGD USDZAR USDRUB EURRUB SILVER GOLD DE30 DX F40 JP225 UK100 US30 US500 USTEC _AA _AAPL _AMZN _AXP _BA _BAC _CAT _CSCO _CVX _DD _DIS _EBAY _FB _GE _GOOG _HAL _HD _HON _HPQ _IBM _INTC _IP _JNJ _JPM _KO _MCD _MCO _MMM _MO _MRK _MSFT _PFE _PG _PM _T _UTX _VZ _WMT _WU _XOM _XRX _YHOO _YNDX _SBER _LKOH _GAZP _AVAZ _ROSN ZC ZS KC SB CT BRENT WTI NG',
    'quote_str' => 'AUDCAD AUDCHF AUDJPY AUDNZD AUDSGD AUDUSD EURAUD EURCAD EURCHF EURGBP EURJPY EURSGD EURUSD GBPAUD GBPCAD GBPCHF GBPJPY GBPSGD GBPUSD NZDCAD NZDCHF NZDJPY NZDUSD USDCAD USDCHF USDDKK USDJPY USDMXN USDNOK USDSEK USDSGD USDZAR USDRUB EURRUB SILVER GOLD DE30 DX F40 JP225 UK100 US30 US500 USTEC _AA _AAPL _AMZN _AXP _BA _BAC _CAT _CSCO _CVX _DD _DIS _EBAY _FB _GE _GOOG _HAL _HD _HON _HPQ _IBM _INTC _IP _JNJ _JPM _KO _MCD _MCO _MMM _MO _MRK _MSFT _PFE _PG _PM _T _UTX _VZ _WMT _WU _XOM _XRX _YHOO _YNDX _SBER _LKOH _GAZP _AVAZ _ROSN ZC ZS KC SB CT BRENT WTI NG',
    
    'monthes'=>array(
        '1'=>'Январь',
        '2'=>'Февраль',
        '3'=>'Март',
        '4'=>'Апрель',
        '5'=>'Май',
        '6'=>'Июнь',
        '7'=>'Июль',
        '8'=>'Август',
        '9'=>'Сентябрь',
        '10'=>'Октябрь',
        '11'=>'Ноябрь',
        '12'=>'Декабрь'
    ),
    
    'stockType' => array(
            '1'=>'Валюты',
            '2'=>'Металлы',
            '3'=>'Индексы',
            '4'=>'Амер. Акции',
            '5'=>'Рус. Акции',
            '6'=>'Товары',
            '7'=>'Енергия',
        ),

     'quote'=>array(
             'AUDCAD'=>1    //Australian Dollar vs Canadian Dollar
            ,'AUDCHF'=>2    //Australian Dollar vs Swiss Franc
            ,'AUDJPY'=>3    //Australian Dollar vs Japanese Yen
            ,'AUDNZD'=>4    //Australian Dollar vs New Zealand Dollar
            ,'AUDSGD'=>5    //Australian Dollar vs Singapore Dollar
            ,'AUDUSD'=>6    //Australian Dollar vs US Dollar
            ,'EURAUD'=>7    //Euro vs Australian Dollar
            ,'EURCAD'=>8    //Euro vs Canadian Dollar
            ,'EURCHF'=>9    //Euro vs Swiss Franc
            ,'EURGBP'=>10   //Euro vs Great Britain Pound
            ,'EURJPY'=>11   //Euro vs Japanese Yen
            ,'EURSGD'=>12   //Euro vs Singapore Dollar
            ,'EURUSD'=>13   //Euro vs US Dollar
            ,'GBPAUD'=>14   //Great Britain Pound vs Australian Dollar
            ,'GBPCAD'=>15   //Great Britain Pound vs Canadian Dollar
            ,'GBPCHF'=>16   //Great Britain Pound vs Swiss Franc
            ,'GBPJPY'=>17   //Great Britain Pound vs Japanese Yen
            ,'GBPSGD'=>18   //Great Britain Pound vs Singapore Dollar
            ,'GBPUSD'=>19   //Great Britain Pound vs US Dollar
            ,'NZDCAD'=>20   //New Zealand Dollar vs Canadian Dollar
            ,'NZDCHF'=>21   //New Zealand Dollar vs Swiss Franc
            ,'NZDJPY'=>22   //New Zealand Dollar vs Japanese Yen
            ,'NZDUSD'=>23   //New Zealand Dollar vs US Dollar
            ,'USDCAD'=>24   //US Dollar vs Canadian Dollar
            ,'USDCHF'=>25   //US Dollar vs Swiss Franc
            ,'USDDKK'=>26   //US Dollar vs Danish Krone
            ,'USDJPY'=>27   //US Dollar vs Japanese Yen
            ,'USDMXN'=>28   //US Dollar vs Mexican Peso
            ,'USDNOK'=>29   //US Dollar vs Norwegian Krone
            ,'USDSEK'=>30   //US Dollar vs Sweden Kronor
            ,'USDSGD'=>31   //US Dollar vs Singapore Dollar
            ,'USDZAR'=>32   //US Dollar vs South Africa Rand
            ,'USDRUB'=>33   //US Dollar vs Russian Ruble
            ,'EURRUB'=>34   //Euro vs Russian Ruble
        
            ,'SILVER'=>35   //Silver
            ,'GOLD'=>36     //GOLD
        
            ,'DE30'=>37     //Xetra DAX Index
            ,'DX'=>38       //US Dollar Index
            ,'F40'=>39      //CAC40 Index
            ,'JP225'=>40    //Nikkei 225 Index
            ,'UK100'=>41    //FTSE 100 Index
            ,'US30'=>42     //DJIA Index
            ,'US500'=>43    //S&P 500 Index
            ,'USTEC'=>44    //Nasdaq 100
        
            ,'_AA'=>45       //Alcoa Inc
            ,'_AAPL'=>46    //Apple Computer Inc
            ,'_AMZN'=>47    //Amazon Com Inc
            ,'_AXP'=>48     //American Express Company
            ,'_BA'=>49      //Boeing Company
            ,'_BAC'=>50     //Bank of America
            ,'_CAT'=>51     //Caterpillar Inc
            ,'_CSCO'=>52    //Cisco Sys Inc
            ,'_CVX'=>53     //Chevron
            ,'_DD'=>54      //DuPont
            ,'_DIS'=>55     //Walt Disnay Company
            ,'_EBAY'=>56    //Ebay Inc
            ,'_FB'=>57      //Facebook
            ,'_GE'=>58      //General Electric Corporation
            ,'_GOOG'=>59    //Google Inc
            ,'_HAL'=>60     //Halliburton Co
            ,'_HD'=>61      //Home Depot Inc
            ,'_HON'=>62     //Honeywell International Inc
            ,'_HPQ'=>63     //Hewlett-Packard Company
            ,'_IBM'=>64     //IBM Corporation
            ,'_INTC'=>65    //Intel Corporation
            ,'_IP'=>66      //International Paper Company
            ,'_JNJ'=>67     //Johnson & Johnson
            ,'_JPM'=>68     //JPMorgan Chase & Co
            ,'_KO'=>69      //Coca-Cola Company
            ,'_MCD'=>70     //McDonalds Corporation
            ,'_MCO'=>71     //Moodys
            ,'_MMM'=>72     //3M Company
            ,'_MO'=>73      //Altria Group Inc
            ,'_MRK'=>74     //Merk & Co Inc
            ,'_MSFT'=>75    //Microsoft Corporation
            ,'_PFE'=>76     //Pfizer Inc
            ,'_PG'=>77      //Procter & Gamble Company
            ,'_PM'=>78      //Philip Morris Intl
            ,'_T'=>79       //AT&T
            ,'_UTX'=>80     //United Technologies Corporation
            ,'_VZ'=>81      //Verizion Communications Inc
            ,'_WMT'=>82     //Wal-Mart Stores Inc
            ,'_WU'=>83      //Western Union
            ,'_XOM'=>84     //ExxonMobil Corporation
            ,'_XRX'=>85     //Xerox Corp
            ,'_YHOO'=>86    //Yahoo Inc
            ,'_YNDX'=>87    //Yandex
        
            ,'_SBER'=>88     //Sberbank
            ,'_LKOH'=>89    //LUKOIL
            ,'_GAZP'=>90    //Gazprom
            ,'_AVAZ'=>91    //AvtoVAZ
            ,'_ROSN'=>92    //Rosneft
        
            ,'ZC'=>93        //US Corn
            ,'ZS'=>94       //US Soybeans
            ,'KC'=>95       //US Coffe
            ,'SB'=>96       //US Sugar No. 11
            ,'CT'=>97       //US Cotton No. 2
        
            ,'BRENT'=>98     //Brent Crude Oil
            ,'WTI'=>99      //WTI Light Crude Oil
            ,'NG'=>100       //Natural Gas
        )
);

$this->addCSS("bootstrap.min")->addCSS("main");
$this->preAddJS('jquery')->addJS('angular.min')->addJS('bootstrap.min')->addJS('main');
?>