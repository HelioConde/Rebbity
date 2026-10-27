<?php
declare(strict_types=1);
require_once __DIR__ . '/../app/bootstrap.php';
$partner = rb_partner();
header('Cache-Control: private, no-store');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Meta tags Obrigatórias -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta data-react-helmet="true" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="google-site-verification" content="eCqVEvLp0OnUHoDt4DdxI1-ibPq5QqyWyry4As8JwT4" />
    <meta data-react-helmet="true" name="keywords" content="Rebbity,delivery,food,parceiro,parceiros">
    <meta data-react-helmet="true" name="subject" content="Segurança eletrônica">
    <meta data-react-helmet="true" name="language" content="pt-br">
    <meta data-react-helmet="true" name="robots" content="noindex,nofollow">
    <meta data-react-helmet="true" name="revised" content="21/12/2021 12:00">
    <meta data-react-helmet="true" name="abstract" content="Segurança eletrônica">
    <meta data-react-helmet="true" name="topic" content="Segurança eletrônica">
    <meta data-react-helmet="true" name="summary" content="Segurança eletrônica de condominios">
    <meta data-react-helmet="true" name="copyright" content="Francisco Hélio Conde dos Santos">
    <meta data-react-helmet="true" name="owner" content="Francisco Hélio Conde dos Santos">
    <meta data-react-helmet="true" name="url" content="https://parceiros.rebbity.com/">
    <meta data-react-helmet="true" name="identifier-URL" content="https://parceiros.rebbity.com/">
    <meta data-react-helmet="true" name="coverage" content="Brasilia">
    <meta data-react-helmet="true" name="distribution" content="Brasil">
    <meta data-react-helmet="true" name="rating" content="General">
    <meta data-react-helmet="true" name="revisit-after" content="360 days">
    <meta data-react-helmet="true" name="description"
        content="Cadastre-se com a Rebbity agora e venda muito mais com o aplicativo de delivery mais amado do Brasil.">
    <meta data-react-helmet="true" property="og:title" content="Seja um parceiro Rebbity">
    <meta data-react-helmet="true" property="og:description"
        content="Cadastre-se com a Rebbity agora e venda muito mais com o aplicativo de delivery mais amado do Brasil.">
    <meta data-react-helmet="true" property="og:image" content="https://parceiros.rebbity.com/img/logo2.png">
    <meta data-react-helmet="true" property="og:type" content="website">
    <meta data-react-helmet="true" name="og:url" content="https://parceiros.rebbity.com/">
    <meta data-react-helmet="true" name="og:site_name" content="Seja um parceiro Rebbity">
    <meta data-react-helmet="true" name="og:email" content="suporte@milionariocomdelivery.com.br">
    <meta data-react-helmet="true" name="og:fax_number" content="null">
    <meta data-react-helmet="true" name="og:latitude" content="-15.7801">
    <meta data-react-helmet="true" name="og:longitude" content="-47.9292">
    <meta data-react-helmet="true" name="og:street-address" content="Brasilia">
    <meta data-react-helmet="true" name="og:locality" content="Brasilia">
    <meta data-react-helmet="true" name="og:region" content="DF">
    <meta data-react-helmet="true" name="og:postal-code" content="70040-020">
    <meta data-react-helmet="true" name="og:country-name" content="Brasil">
    <meta data-react-helmet="true" name="fb:page_id" content="100006736034361">
    <meta data-react-helmet="true" property="fb:admins" content="100006736034361">
    <meta property="googlebot" content="noindex,nofollow">
    <meta http-equiv="Expires" content="2023">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta data-react-helmet="true" name="twitter:title" content="Seja um parceiro Rebbity">
    <meta data-react-helmet="true" name="twitter:description"
        content="Cadastre-se com a Rebbity agora e venda muito mais com o aplicativo de delivery mais amado do Brasil.">
    <meta data-react-helmet="true" name="twitter:image" content="https://parceiros.rebbity.com//logo2.png">
    <meta data-react-helmet="true" name="twitter:card" content="summary_large_image">
    <meta data-react-helmet="true" name="twitter:site" content="@rebbitybrasil">

    <title>Seja um parceiro Rebbity</title>

    <link rel="apple-touch-icon" sizes="57x57" href="../favicons/favicon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../favicons/favicon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../favicons/favicon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../favicons/favicon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../favicons/favicon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../favicons/favicon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../favicons/favicon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../favicons/favicon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../favicons/favicon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../favicons/favicon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicons/favicon-16x16.png">
    <link rel="shortcut icon" href="../favicons/favicon.ico" type="image/x-icon">
    <link rel="alternate" hreflang="pt-br" href="https://parceiros.rebbity.com/">
    <link rel="canonical" href="https://parceiros.rebbity.com/" data-baseprotocol="https:"
        data-basehost="perimetroseg.com.br">

    <!-- CSS Style -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../css/foundation.css">

    <!-- JS -->
    <script src="js/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="<?php echo rb_h(rb_csrf_token()); ?>">
</head>

<body>
    <a class="skip-link" href="#main-content">Pular para o conteúdo principal</a>
    <div id="flex">
        <div id="nav">
            <div id="mobileBar">
                <div id="showMobile" role="button" tabindex="0" aria-label="Abrir menu" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                        <path
                            d="M0 96C0 78.33 14.33 64 32 64H416C433.7 64 448 78.33 448 96C448 113.7 433.7 128 416 128H32C14.33 128 0 113.7 0 96zM0 256C0 238.3 14.33 224 32 224H416C433.7 224 448 238.3 448 256C448 273.7 433.7 288 416 288H32C14.33 288 0 273.7 0 256zM416 448H32C14.33 448 0 433.7 0 416C0 398.3 14.33 384 32 384H416C433.7 384 448 398.3 448 416C448 433.7 433.7 448 416 448z" />
                    </svg>
                </div>
                <div>
                    <div class="logo">
                        <img src="../img/logo.png" alt="logo">
                    </div>
                </div>
                <div>

                </div>
            </div>
            <div>
                <nav>
                    <div class="logo">
                        <img src="../img/logo.png" alt="logo">
                    </div>

                    <div class="shopName"><?php echo rb_h($partner['name']); ?></div>

                    <div class="status">
                        <div class="statusIcon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                <path
                                    d="M506.3 417l-213.3-364c-16.33-28-57.54-28-73.98 0l-213.2 364C-10.59 444.9 9.849 480 42.74 480h426.6C502.1 480 522.6 445 506.3 417zM232 168c0-13.25 10.75-24 24-24S280 154.8 280 168v128c0 13.25-10.75 24-23.1 24S232 309.3 232 296V168zM256 416c-17.36 0-31.44-14.08-31.44-31.44c0-17.36 14.07-31.44 31.44-31.44s31.44 14.08 31.44 31.44C287.4 401.9 273.4 416 256 416z" />
                            </svg>
                        </div>
                        <div>
                            <div class="statusShop">Catálogo em edição</div>
                            <div>Gestor de pedidos</div>
                        </div>
                    </div>

                    <div class="nav">
                        <div class="navBar">
                            <div class="active">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M575.8 255.5C575.8 273.5 560.8 287.6 543.8 287.6H511.8L512.5 447.7C512.5 450.5 512.3 453.1 512 455.8V472C512 494.1 494.1 512 472 512H456C454.9 512 453.8 511.1 452.7 511.9C451.3 511.1 449.9 512 448.5 512H392C369.9 512 352 494.1 352 472V384C352 366.3 337.7 352 320 352H256C238.3 352 224 366.3 224 384V472C224 494.1 206.1 512 184 512H128.1C126.6 512 125.1 511.9 123.6 511.8C122.4 511.9 121.2 512 120 512H104C81.91 512 64 494.1 64 472V360C64 359.1 64.03 358.1 64.09 357.2V287.6H32.05C14.02 287.6 0 273.5 0 255.5C0 246.5 3.004 238.5 10.01 231.5L266.4 8.016C273.4 1.002 281.4 0 288.4 0C295.4 0 303.4 2.004 309.5 7.014L564.8 231.5C572.8 238.5 576.9 246.5 575.8 255.5L575.8 255.5z" />
                                    </svg>
                                </div>
                                <div>
                                    <a href="./index.php?pag=index">Início</a>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M381.2 150.3L524.9 171.5C536.8 173.2 546.8 181.6 550.6 193.1C554.4 204.7 551.3 217.3 542.7 225.9L438.5 328.1L463.1 474.7C465.1 486.7 460.2 498.9 450.2 506C440.3 513.1 427.2 514 416.5 508.3L288.1 439.8L159.8 508.3C149 514 135.9 513.1 126 506C116.1 498.9 111.1 486.7 113.2 474.7L137.8 328.1L33.58 225.9C24.97 217.3 21.91 204.7 25.69 193.1C29.46 181.6 39.43 173.2 51.42 171.5L195 150.3L259.4 17.97C264.7 6.954 275.9-.0391 288.1-.0391C300.4-.0391 311.6 6.954 316.9 17.97L381.2 150.3z" />
                                    </svg>
                                </div>
                                <div>
                                    <a href="./index.php?pag=rating">Avaliações</a>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M336 64h-53.88C268.9 26.8 233.7 0 192 0S115.1 26.8 101.9 64H48C21.5 64 0 85.48 0 112v352C0 490.5 21.5 512 48 512h288c26.5 0 48-21.48 48-48v-352C384 85.48 362.5 64 336 64zM192 64c17.67 0 32 14.33 32 32c0 17.67-14.33 32-32 32S160 113.7 160 96C160 78.33 174.3 64 192 64zM272 224h-160C103.2 224 96 216.8 96 208C96 199.2 103.2 192 112 192h160C280.8 192 288 199.2 288 208S280.8 224 272 224z" />
                                    </svg>
                                </div>
                                <div>
                                    <a href="./index.php?pag=rating">Requests</a>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M160 0C177.7 0 192 14.33 192 32V67.68C193.6 67.89 195.1 68.12 196.7 68.35C207.3 69.93 238.9 75.02 251.9 78.31C268.1 82.65 279.4 100.1 275 117.2C270.7 134.3 253.3 144.7 236.1 140.4C226.8 137.1 198.5 133.3 187.3 131.7C155.2 126.9 127.7 129.3 108.8 136.5C90.52 143.5 82.93 153.4 80.92 164.5C78.98 175.2 80.45 181.3 82.21 185.1C84.1 189.1 87.79 193.6 95.14 198.5C111.4 209.2 136.2 216.4 168.4 225.1L171.2 225.9C199.6 233.6 234.4 243.1 260.2 260.2C274.3 269.6 287.6 282.3 295.8 299.9C304.1 317.7 305.9 337.7 302.1 358.1C295.1 397 268.1 422.4 236.4 435.6C222.8 441.2 207.8 444.8 192 446.6V480C192 497.7 177.7 512 160 512C142.3 512 128 497.7 128 480V445.1C127.6 445.1 127.1 444.1 126.7 444.9L126.5 444.9C102.2 441.1 62.07 430.6 35 418.6C18.85 411.4 11.58 392.5 18.76 376.3C25.94 360.2 44.85 352.9 60.1 360.1C81.9 369.4 116.3 378.5 136.2 381.6C168.2 386.4 194.5 383.6 212.3 376.4C229.2 369.5 236.9 359.5 239.1 347.5C241 336.8 239.6 330.7 237.8 326.9C235.9 322.9 232.2 318.4 224.9 313.5C208.6 302.8 183.8 295.6 151.6 286.9L148.8 286.1C120.4 278.4 85.58 268.9 59.76 251.8C45.65 242.4 32.43 229.7 24.22 212.1C15.89 194.3 14.08 174.3 17.95 153C25.03 114.1 53.05 89.29 85.96 76.73C98.98 71.76 113.1 68.49 128 66.73V32C128 14.33 142.3 0 160 0V0z" />
                                    </svg>
                                </div>
                                <div>
                                    <a href="./index.php?pag=financial">Financeiro</a>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M320 0H64C37.49 0 16 21.49 16 48v416C16 490.5 37.49 512 64 512h256c26.51 0 48-21.49 48-48v-416C368 21.49 346.5 0 320 0zM192 464c-17.75 0-32-14.25-32-32s14.25-32 32-32s32 14.25 32 32S209.8 464 192 464z" />
                                    </svg>
                                </div>
                                <div>
                                    <a href="./index.php?pag=digitalMenu">Cardápio digital</a>
                                </div>
                            </div>
                        </div>

                        <div class="navBar">
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M448 336v-288C448 21.49 426.5 0 400 0H96C42.98 0 0 42.98 0 96v320c0 53.02 42.98 96 96 96h320c17.67 0 32-14.33 32-31.1c0-11.72-6.607-21.52-16-27.1v-81.36C441.8 362.8 448 350.2 448 336zM143.1 128h192C344.8 128 352 135.2 352 144C352 152.8 344.8 160 336 160H143.1C135.2 160 128 152.8 128 144C128 135.2 135.2 128 143.1 128zM143.1 192h192C344.8 192 352 199.2 352 208C352 216.8 344.8 224 336 224H143.1C135.2 224 128 216.8 128 208C128 199.2 135.2 192 143.1 192zM384 448H96c-17.67 0-32-14.33-32-32c0-17.67 14.33-32 32-32h288V448z" />
                                    </svg>
                                </div>
                                <div>
                                    <a href="./index.php?pag=menu">Cardápio</a>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512zM232 256C232 264 236 271.5 242.7 275.1L338.7 339.1C349.7 347.3 364.6 344.3 371.1 333.3C379.3 322.3 376.3 307.4 365.3 300L280 243.2V120C280 106.7 269.3 96 255.1 96C242.7 96 231.1 106.7 231.1 120L232 256z" />
                                    </svg>
                                </div>
                                <div>
                                    Horários
                                </div>
                            </div>
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M273.2 311.1C241.1 271.9 167.1 174.6 167.1 120C167.1 53.73 221.7 0 287.1 0C354.3 0 408 53.73 408 120C408 174.6 334.9 271.9 302.8 311.1C295.1 321.6 280.9 321.6 273.2 311.1V311.1zM416 503V200.4C419.5 193.5 422.7 186.7 425.6 179.8C426.1 178.6 426.6 177.4 427.1 176.1L543.1 129.7C558.9 123.4 576 135 576 152V422.8C576 432.6 570 441.4 560.9 445.1L416 503zM15.09 187.3L137.6 138.3C140 152.5 144.9 166.6 150.4 179.8C153.3 186.7 156.5 193.5 160 200.4V451.8L32.91 502.7C17.15 508.1 0 497.4 0 480.4V209.6C0 199.8 5.975 190.1 15.09 187.3H15.09zM384 504.3L191.1 449.4V255C212.5 286.3 234.3 314.6 248.2 331.1C268.7 357.6 307.3 357.6 327.8 331.1C341.7 314.6 363.5 286.3 384 255L384 504.3z" />
                                    </svg>
                                </div>
                                <div>
                                    Áreas de entrega
                                </div>
                            </div>
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M512 32C547.3 32 576 60.65 576 96V128H0V96C0 60.65 28.65 32 64 32H512zM576 416C576 451.3 547.3 480 512 480H64C28.65 480 0 451.3 0 416V224H576V416zM112 352C103.2 352 96 359.2 96 368C96 376.8 103.2 384 112 384H176C184.8 384 192 376.8 192 368C192 359.2 184.8 352 176 352H112zM240 384H368C376.8 384 384 376.8 384 368C384 359.2 376.8 352 368 352H240C231.2 352 224 359.2 224 368C224 376.8 231.2 384 240 384z" />
                                    </svg>
                                </div>
                                <div>
                                    Formas de pagamento
                                </div>
                            </div>
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M374.6 73.39c-12.5-12.5-32.75-12.5-45.25 0l-320 320c-12.5 12.5-12.5 32.75 0 45.25C15.63 444.9 23.81 448 32 448s16.38-3.125 22.62-9.375l320-320C387.1 106.1 387.1 85.89 374.6 73.39zM64 192c35.3 0 64-28.72 64-64S99.3 64.01 64 64.01S0 92.73 0 128S28.7 192 64 192zM320 320c-35.3 0-64 28.72-64 64s28.7 64 64 64s64-28.72 64-64S355.3 320 320 320z" />
                                    </svg>
                                </div>
                                <div>
                                    Promoções
                                </div>
                            </div>
                        </div>

                        <div class="navBar">
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M280 145.3V112h16C309.3 112 320 101.3 320 88S309.3 64 296 64H215.1C202.7 64 192 74.75 192 87.1S202.7 112 215.1 112H232v33.32C119.6 157.3 32 252.4 32 368h448C480 252.4 392.4 157.3 280 145.3zM488 400h-464C10.75 400 0 410.7 0 423.1C0 437.3 10.75 448 23.1 448h464c13.25 0 24-10.75 24-23.1C512 410.7 501.3 400 488 400z" />
                                    </svg>
                                </div>
                                <div>
                                    Vantagens do Chef
                                </div>
                            </div>
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M331.8 224.1c28.29 0 54.88 10.99 74.86 30.97l19.59 19.59c40.01-17.74 71.25-53.3 81.62-96.65c5.725-23.92 5.34-47.08 .2148-68.4c-2.613-10.88-16.43-14.51-24.34-6.604l-68.9 68.9h-75.6V97.2l68.9-68.9c7.912-7.912 4.275-21.73-6.604-24.34c-21.32-5.125-44.48-5.51-68.4 .2148c-55.3 13.23-98.39 60.22-107.2 116.4C224.5 128.9 224.2 137 224.3 145l82.78 82.86C315.2 225.1 323.5 224.1 331.8 224.1zM384 278.6c-23.16-23.16-57.57-27.57-85.39-13.9L191.1 158L191.1 95.99l-127.1-95.99L0 63.1l96 127.1l62.04 .0077l106.7 106.6c-13.67 27.82-9.251 62.23 13.91 85.39l117 117.1c14.62 14.5 38.21 14.5 52.71-.0016l52.75-52.75c14.5-14.5 14.5-38.08-.0016-52.71L384 278.6zM227.9 307L168.7 247.9l-148.9 148.9c-26.37 26.37-26.37 69.08 0 95.45C32.96 505.4 50.21 512 67.5 512s34.54-6.592 47.72-19.78l119.1-119.1C225.5 352.3 222.6 329.4 227.9 307zM64 472c-13.25 0-24-10.75-24-24c0-13.26 10.75-24 24-24S88 434.7 88 448C88 461.3 77.25 472 64 472z" />
                                    </svg>
                                </div>
                                <div>
                                    Serviços
                                </div>
                            </div>
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M0 155.2C0 147.9 2.153 140.8 6.188 134.7L81.75 21.37C90.65 8.021 105.6 0 121.7 0H518.3C534.4 0 549.3 8.021 558.2 21.37L633.8 134.7C637.8 140.8 640 147.9 640 155.2C640 175.5 623.5 192 603.2 192H36.84C16.5 192 .0003 175.5 .0003 155.2H0zM64 224H128V384H320V224H384V464C384 490.5 362.5 512 336 512H112C85.49 512 64 490.5 64 464V224zM512 224H576V480C576 497.7 561.7 512 544 512C526.3 512 512 497.7 512 480V224z" />
                                    </svg>
                                </div>
                                <div>
                                    Perfil
                                </div>
                            </div>
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M64 400C64 408.8 71.16 416 80 416H480C497.7 416 512 430.3 512 448C512 465.7 497.7 480 480 480H80C35.82 480 0 444.2 0 400V64C0 46.33 14.33 32 32 32C49.67 32 64 46.33 64 64V400zM342.6 278.6C330.1 291.1 309.9 291.1 297.4 278.6L240 221.3L150.6 310.6C138.1 323.1 117.9 323.1 105.4 310.6C92.88 298.1 92.88 277.9 105.4 265.4L217.4 153.4C229.9 140.9 250.1 140.9 262.6 153.4L320 210.7L425.4 105.4C437.9 92.88 458.1 92.88 470.6 105.4C483.1 117.9 483.1 138.1 470.6 150.6L342.6 278.6z" />
                                    </svg>
                                </div>
                                <div>
                                    Desempenho
                                </div>
                            </div>
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M490.7 345.4L435.6 256l55.1-89.38c14.87-24.25-3.62-54.61-33.12-54.61l-110.6-.005l-57.87-93.1C281.7 6.003 268.9 0 256 0C243.1 0 230.3 6.003 222.9 18L165 112H54.39c-29.62 0-47.99 30.37-33.12 54.62L76.37 256l-55.1 89.38C6.4 369.6 24.77 399.1 54.39 399.1h110.6l57.87 93.1C230.3 505.1 243.1 512 256 512c12.88 0 25.74-6.002 33.12-18l57.83-93.1h110.7C487.2 399.1 505.6 369.6 490.7 345.4zM256 73.77l23.59 38.23H232.5L256 73.77zM89.48 343.1l20.59-33.35l20.45 33.35H89.48zM110 201.3L89.48 168h41.04L110 201.3zM256 438.2l-23.59-38.25h47.08L256 438.2zM313.9 343.1H198L143.8 256l54.22-87.1h116L368.3 256L313.9 343.1zM381.3 343.1l20.67-33.29l20.52 33.29H381.3zM401.1 201.3l-20.51-33.29h41.04L401.1 201.3z" />
                                    </svg>
                                </div>
                                <div>
                                    Super‑Restaurantes
                                </div>
                            </div>
                        </div>

                        <div class="navBar">
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M112 112C112 50.14 162.1 0 224 0C285.9 0 336 50.14 336 112V160H400C426.5 160 448 181.5 448 208V416C448 469 405 512 352 512H96C42.98 512 0 469 0 416V208C0 181.5 21.49 160 48 160H112V112zM160 160H288V112C288 76.65 259.3 48 224 48C188.7 48 160 76.65 160 112V160zM136 256C149.3 256 160 245.3 160 232C160 218.7 149.3 208 136 208C122.7 208 112 218.7 112 232C112 245.3 122.7 256 136 256zM312 208C298.7 208 288 218.7 288 232C288 245.3 298.7 256 312 256C325.3 256 336 245.3 336 232C336 218.7 325.3 208 312 208z" />
                                    </svg>
                                </div>
                                <div>
                                    Rebb Shop
                                </div>
                            </div>
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M0 144v288C0 457.6 22.41 480 48 480H64V96H48C22.41 96 0 118.4 0 144zM464 96H448v384h16c25.59 0 48-22.41 48-48v-288C512 118.4 489.6 96 464 96zM384 48C384 22.41 361.6 0 336 0h-160C150.4 0 128 22.41 128 48V96H96v384h320V96h-32V48zM176 48h160V96h-160V48zM352 312C352 316.4 348.4 320 344 320H288v56c0 4.375-3.625 8-8 8h-48C227.6 384 224 380.4 224 376V320H168C163.6 320 160 316.4 160 312v-48C160 259.6 163.6 256 168 256H224V200C224 195.6 227.6 192 232 192h48C284.4 192 288 195.6 288 200V256h56C348.4 256 352 259.6 352 264V312z" />
                                    </svg>
                                </div>
                                <div>
                                    Chamados e ajuda
                                </div>
                            </div>
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M400 32h-352C21.49 32 0 53.49 0 80v352C0 458.5 21.49 480 48 480h245.5c16.97 0 33.25-6.744 45.26-18.75l90.51-90.51C441.3 358.7 448 342.5 448 325.5V80C448 53.49 426.5 32 400 32zM64 96h320l-.001 224H320c-17.67 0-32 14.33-32 32v64H64V96z" />
                                    </svg>
                                </div>
                                <div>
                                    Políticas
                                </div>
                            </div>
                        </div>

                        <div class="navBar">
                            <div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <!--! Font Awesome Pro 6.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                        <path
                                            d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z" />
                                    </svg>
                                </div>
                                <div>
                                    <?php echo rb_h($partner['email']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <form method="post" action="./logout.php" class="rb-logout">
                <input type="hidden" name="_csrf" value="<?php echo rb_h(rb_csrf_token()); ?>">
                <button type="submit">Sair da conta</button>
              </form>
              </nav>
            </div>
        </div>
        <main id="main-content" tabindex="-1">

        </main>
    </div>
    <script>
      jQuery.ajaxPrefilter(function (settings, original, xhr) {
        if (/^(POST|PUT|PATCH|DELETE)$/i.test(settings.type) &&
            new URL(settings.url, location.href).origin === location.origin) {
          xhr.setRequestHeader('X-CSRF-Token', document.querySelector('meta[name="csrf-token"]').content);
        }
      });
    </script>
    <script src="js/script.js"></script>
    <script src="./js/nav.js"></script>
</body>
<script>
    var query = location.search.slice(1);
    var partes = query.split('&');
    var data = {};
    partes.forEach(function (parte) {
        var chaveValor = parte.split('=');
        var chave = chaveValor[0];
        var valor = chaveValor[1];
        data[chave] = valor;
    });

    if (data.page == 'index') {
        $("#alert").css("display", "flex");
        $(".alertText").html('Senha incorreta!');
    }
    if (data.erro == 'email') {
        $("#alert").css("display", "flex");
        $(".alertText").html('E-mail incorreto!');
    }

    $("#confirmBox").on('mouseup', function () {
        $("#alert").css("display", "none");
    })
</script>

</html>