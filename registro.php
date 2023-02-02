<?php
session_start();
include_once 'php/inc/header.inc.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/img/webico.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/style/style.css">
    <title>Registro</title>
</head>

<body onload="checkSesion();" class="inicio">
    <div class="container" style="cursor:url(https://cdn.custom-cursor.com/db/cursor/32/Infinity_Gauntlet_Cursor.png) , default!important">
        <div class="svg-container">
            <svg width="117px" height="170px" viewBox="-2 -2 236 342" version="1.1">
                <!-- etiqueta svg con style  -->
                <defs>
                    <style type="text/css">
                        body {
                            background-color: rgb(30, 30, 30);
                        }

                        svg-container {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                        }

                        svg {
                            position: absolute;
                            top: 15%;
                            left: 39%;
                            transform: translate(-50%, -50%);
                        }

                        .path {
                            stroke-dashoffset: 1940;
                            stroke-dasharray: 1940;
                            animation: draw 10s linear infinite;
                            fill-opacity: 0;
                        }

                        @keyframes draw {
                            30% {
                                fill-opacity: 0;
                            }

                            31% {
                                fill-opacity: 1;
                            }

                            32% {
                                fill-opacity: 0;
                            }

                            33% {
                                fill-opacity: 1;
                            }

                            34% {
                                fill-opacity: 0;
                            }

                            35% {
                                fill-opacity: 1;
                            }

                            50% {
                                stroke-dashoffset: 0;
                            }

                            90% {
                                stroke-dashoffset: 0;
                                fill-opacity: 1;
                            }
                        }
                    </style>
                </defs>

                <g id="Group" stroke="rgb(180,20,20)" stroke-width="2" fill="none">
                    <!--CHANGE LINE COLOUR-->

                    <path class="path" d="M5.63276137,182.54231 C6.80194953,193.172437 6.3213287,203.463688 8.78389181,213.305988 C10.8893725,221.721111 17.2164459,227.370951 20.3046414,235.047931 C22.6954227,240.991202 26.777593,245.814282 29.6168696,251.304822 C35.2175982,262.135407 56.0371828,337.714307 56.0371828,337.714307 L132.704815,337.714307 C132.704815,337.714307 160.705733,315.283257 173.036553,307.661609 C182.772217,301.64402 198.272915,283.720624 198.272915,283.720624 C198.272915,283.720624 206.932701,245.86977 214.495314,229.699603 C217.836426,222.555731 220.443269,212.466228 222.464701,200.907166 C222.48683,200.780625 223.103167,200.325007 223.266634,200.163245 C223.681908,199.7523 223.934824,199.476798 224.4066,198.785907 C225.002278,197.913567 225.542985,196.991182 225.943324,196.093396 C226.210144,195.495036 226.511624,194.766691 226.738562,194.309912 C227.147039,193.487729 227.618919,191.858807 227.823369,191.187781 C228.253181,189.777088 228.495384,189.025237 228.650347,188.166614 C228.683934,187.980515 230.030425,182.597722 230.883627,176.052008 C231.263252,173.139547 231.535873,170.000075 231.687372,166.980798 C231.753545,165.661991 231.803387,164.400955 231.888486,163.157758 C232.04826,160.823641 231.98299,158.213817 231.974911,155.880066 C231.957094,150.733641 231.600491,145.751759 231.121789,141.324454 C230.120098,132.060257 228.59446,125.32839 228.59446,125.32839 C228.59446,125.32839 228.650347,120.08005 228.650347,117.658292 C228.650347,108.520701 224.714553,97.0342203 223.830314,89.1118744 C218.874905,44.7138416 207.944892,26.1540212 179.03144,14.5543922 C163.897012,8.4826969 139.335592,0 117.79845,0 C79.2072247,0 35.7979014,21.0164772 12.5429347,54.868483 C3.90403848,67.4440326 4.65665878,81.6018722 1.51397958,97.2334808 C-2.23398125,115.875745 1.51397953,136.521269 1.51397953,157.8 C1.51397953,166.642709 4.70375912,174.095923 5.63276137,182.54231 Z"></path>

                    <path class="path" d="M98.6581966,176.290866 C98.6581966,176.290866 99.1212927,178.386675 100.432982,180.066144 C101.725568,181.721155 103.858062,182.956532 105.053563,183.443653 C106.818571,184.162826 110.311163,183.876835 113.999312,183.443653 C118.949437,182.862249 124.226711,181.920462 125.912624,181.88046 C133.685006,181.696046 143.614627,177.756277 143.614627,177.756277 L162.621944,167.942929 L154.49673,157.417364 C154.49673,157.417364 135.505697,163.857703 125.912623,166.790818 C118.42587,169.079918 103.257249,173.084007 103.257249,173.084007 L98.6581966,176.290866 Z" id="right-eye" fill="#4990E2"></path>
                    <!--EYE COLOUR-->

                    <path class="path" d="M11.7128323,170.694824 C11.7128323,170.694824 12.9740116,181.439742 17.4408649,183.185084 C25.715583,186.418281 49.9375458,185.630441 49.9375458,185.630441 L51.3263283,180.653678 L46.3375778,176.781708 L11.7128323,170.694824 Z" id="left-eye" fill="#4990E2"></path>
                    <!--EYE COLOUR-->

                    <ellipse class="path" cx="220.310078" cy="157.2" rx="11.6899225" ry="44.4"></ellipse>

                    <ellipse class="path" cx="223.607235" cy="158.1" rx="8.39276486" ry="35.7"></ellipse>

                    <path class="path" d="M205.16142,257.069968 L204.02662,251.721838 C203.200382,247.827911 201.39308,241.665666 199.983114,237.940156 L186.169296,201.440316 L167.312606,243.098893 L151.529633,274.897142 L149.316556,280.136082 L132.515841,296.568444 L115.514765,285.903702 L55.6979359,286.309327 L51.840989,287.936383 L49.891546,293.800765 L39.4806764,280.264684"></path>

                    <path class="path" d="M194.337627,181.231481 L186.176483,201.202524 L177.196317,213.410805 L163.81206,230.377018 C161.351205,233.496459 157.905145,238.90214 156.109916,242.461162 L153.013738,248.599303 C151.220818,252.153751 149.533749,258.250134 149.245749,262.213442 L148.266938,275.683325 L132.12878,290.819054 L120.219641,280.287181 L49.4682501,281.898244 L46.8615659,290.032871"></path>

                    <path class="path" d="M50.6622452,318.41541 L57.7265898,310.781263 L72.2413693,310.197892 L74.0673855,305.346346 L92.8443872,304.762976 L94.0624903,310.047492 L111.268481,310.047492 L141.060777,319.315335 L178.093387,284.13536 L162.838638,294.929993 L149.217245,280.096174"></path>

                    <ellipse class="path" transform="translate(192.733850, 263.100000) rotate(14.000000) translate(-192.733850, -263.100000) " cx="192.73385" cy="263.1" rx="2.69767442" ry="5.1"></ellipse>

                    <path class="path" d="M174.026355,12.6174134 L169.487865,17.2932552 C166.718666,20.1462603 162.779378,25.2030573 160.689513,28.5874508 L157.323962,34.037732 L165.99062,38.6966084 C169.494422,40.5801238 174.835467,44.1301036 177.932696,46.6358384 L183.991501,51.5375611 L183.847056,57.9405908 C183.757357,61.9168514 183.206733,68.3328583 182.619024,72.2589855 L179.849992,90.7572128 L177.544308,106.765455 C176.977025,110.704073 175.900421,117.053408 175.135484,120.96839 L171.762371,138.232152 L180.930381,153.944907 L188.527514,111.891792 C189.235297,107.973933 190.773363,101.716226 191.956657,97.9347013 L193.54097,92.8716128 C194.72705,89.0811835 196.930253,83.0317212 198.458885,79.3671372 L213.050991,44.385537"></path>

                    <path class="path" d="M141.282422,2.63668846 L134.791041,9.77822094 L127.684098,18.1905018 L124.820956,23.1431151 L145.475765,29.5078751 L157.509038,34.082202"></path>

                    <path class="path" d="M10.5768439,58.0315472 L29.4327053,42.7882975 L36.781002,29.1745233"></path>

                    <path class="path" d="M29.56377,42.6492435 L37.8613285,37.8727934 C41.306665,35.8895019 47.156121,33.2736542 50.9447853,32.0240882 L56.9968728,30.0280067 L57.8640635,27.4624913 C59.137839,23.6941265 61.8466982,17.8819889 63.9130079,14.4831233 L65.5380282,11.8101329"></path>

                    <path class="path" d="M57.0513462,29.8705525 L54.0239924,38.7547732 L52.6332444,46.5628977 C52.6332444,46.5628977 69.9714804,40.2595769 80.2869593,39.6062984 C90.6024382,38.9530199 114.526118,42.6432265 114.526118,42.6432265 L124.725047,23.3094344"></path>

                    <path class="path" d="M52.7116579,46.2577505 L49.3293853,63.3187359 C48.5567286,67.2161995 47.6756075,73.5895679 47.3607301,77.561825 L45.4061251,102.219657 C45.4061251,102.219657 61.1449509,104.931583 69.319265,104.496676 C77.4935791,104.061769 94.4520096,99.6102157 94.4520096,99.6102157 L102.202953,74.4 L107.524761,59.2531816 C108.842522,55.5025957 111.275031,49.5371778 112.953978,45.9375024 L114.417028,42.8007119"></path>

                    <path class="path" d="M60.9313742,43.6619838 L53.9634453,67.9691317 L48.7626755,89.2363215 L45.5140222,102.108393"></path>

                    <path class="path" d="M194.33998,181.375592 L193.480419,177.510239 L180.939272,153.902647 L169.1131,167.786098 L143.405581,182.693266 C139.962313,184.689934 133.943345,186.36864 129.963469,186.44273 L105.939512,186.889966 C101.958906,186.964071 96.1166601,185.61665 96.1166601,185.61665 L96.1166601,185.61665 L94.7940983,177.246507 L50.3680122,179.617432 L47.7784613,188.841251 L42.0031511,189.604686 C38.0627842,190.12556 31.6558219,190.403409 27.6729275,190.224385 L22.7400068,190.00266 C18.7660097,189.824036 13.1719692,187.489732 10.2513565,184.794373 L5.25954168,180.187554"></path>

                    <path class="path" d="M2.09570264,164.827353 L10.5682255,169.574582 L26.6388817,172.732065 L45.412635,175.724716 L50.2845093,179.595116 L94.9253624,177.240092 L102.085958,172.184268 L124.740298,165.946289 L145.350303,159.092409 L153.539474,156.332695 L161.876527,167.044376 L169.458159,167.336156"></path>

                    <path class="path" d="M194.385725,181.150376 L191.447818,185.416533 C189.191398,188.693095 185.005161,193.561922 182.113478,196.276452 L174.985753,202.96751 L162.948539,214.650889 L154.50711,223.72649 C151.799555,226.637452 147.732625,231.626007 145.423648,234.868344 L130.549467,255.755136 C128.240365,258.99765 125.362594,264.684165 124.119589,268.463008 L120.235465,280.271072"></path>

                    <path class="path" d="M18.5087527,231.394093 L29.6506505,248.67255 L39.6642394,263.888481 L46.084218,276.550986 L49.5900589,282.203661"></path>

                    <path class="path" d="M183.95317,51.47048 C183.95317,51.47048 187.731927,43.9277824 190.453645,40.9662534 C193.233164,37.9418299 194.486825,37.5379936 194.486825,37.5379936 C197.783995,35.3148427 203.260042,35.107404 206.716031,37.0735931 L210.103507,39.000803"></path>

                    <path class="path" d="M97.5555478,175.606778 L98.0699842,176.910075 C99.5300542,180.609083 103.912979,183.243725 107.866873,182.793875 L130.153205,180.258275 C134.103808,179.8088 140.186208,177.990916 143.737456,176.198508 L161.783437,167.090228"></path>

                    <path class="path" d="M10.6238966,169.76763 L12.2334207,176.49703 C13.1595567,180.369193 17.1300117,183.615853 21.1105843,183.748946 L48.968031,184.680377"></path>

                </g>
            </svg>
        </div>
        <div class="text-center">
            <img src="./assets/img/logoWeb.png" class="mt-5" width="150px" alt="">
            <h3 class="mt-2">REGISTER SYSTEM</h3>
            <form id="formInsert" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="mb-3">
                    <label for="name" class="form-label">User name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter your name" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="correo" placeholder="name@test.com" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="***********" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>
                <div class="mb-3">
                    <label for="repassword" class="form-label">RePassword</label>
                    <input type="password" class="form-control" id="repassword" placeholder="***********" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>
                <div class="mb-3">
                    <img class="chosenUserProfile mb-2" id="output" src="./assets/img/chosePicture.png" />
                    <input class="form-control" type="file" name="files" id="files" accept=".jpg, .png" onchange="loadFile(event)" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                </div>


                <div class="mb-3">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Leer condiciones y servicios
                    </button>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h1>Términos y condiciones</h1>

                                <p>
                                    Bienvenido a nuestro sitio web. Si continúa navegando y utilizando este sitio web, usted acepta cumplir y estar sujeto a los siguientes términos y condiciones de uso, que junto con nuestra política de privacidad rigen la relación entre usted y nuestra empresa en relación con este sitio web. Si no está de acuerdo con alguno de estos términos, por favor no utilice nuestro sitio web.
                                </p>

                                <h2>Uso del contenido</h2>

                                <p>
                                    El contenido de las páginas de este sitio web es para su información y uso general. Se prohíbe su uso para fines comerciales sin la autorización expresa por escrito de nuestra empresa.

                                <h2>Limitación de responsabilidades</h2>

                                <p>
                                    Este sitio web se proporciona "tal cual". No garantizamos que el sitio web esté disponible en todo momento o que el contenido sea completamente preciso o actualizado. No nos hacemos responsables de ningún tipo de daños o pérdidas en relación con el uso de este sitio web.

                                <h2>Enlaces de terceros</h2>

                                <p>
                                    Este sitio web puede contener enlaces a sitios web de terceros. Estos enlaces se proporcionan sólo como conveniencia y no implican que estemos de acuerdo con el contenido de dichos sitios web. No tenemos control sobre el contenido de los sitios web de terceros y no nos hacemos responsables de ellos.

                                <h2>Derechos de autor</h2>

                                <p>
                                    Todos los contenidos de este sitio web, incluyendo texto, imágenes y diseños, están protegidos por derechos de autor. El uso no autorizado de cualquier contenido puede violar los derechos de autor, marcas registradas y otras leyes.

                                <h2>Política de privacidad</h2>

                                <p>
                                    Su privacidad es importante para nosotros. Lea nuestra política de privacidad para obtener más información sobre cómo recopilamos y usamos la información personal de nuestros usuarios.

                                <h2>Control de cambios</h2>

                                <p>
                                    Nos reservamos el derecho de modificar estos términos y condiciones en cualquier momento. Si hacemos cambios significativos, los notificaremos en esta página.

                                <h2>Contáctenos</h2>

                                <p>
                                    Si tiene alguna pregunta sobre estos términos y condiciones, puede contactarnos en <a href="mailto: infoCliente@WebComics.com">Correo atencion al cliente</a>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <input type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="close">
                                <input type="button" id="test" name="test" data-bs-dismiss="modal" class="btn btn-primary" onclick="changeCheckboxState()" value="Understood">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <?php
                    if (isset($_POST['test'])) {
                        echo "<input type='checkbox' name='checkbox' id='checkbox' value='checkbox' checked readonly disabled>";
                    } else {
                        echo "<input type='checkbox' name='checkbox' id='checkbox' value='checkbox' readonly disabled>";
                    }
                    ?>
                    <label>Acepto y he leido las condiciones y servicios</label>
                </div>

                <div class="mb-3">
                    <input type="button" class="btn btn-danger form-control" onclick="new_user();" value="Registrar" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">
                    <script>
                        function handleFileSelect(evt) {
                            var f = evt.target.files[0]; // FileList object
                            var reader = new FileReader();
                            // Closure to capture the file information.
                            reader.onload = (function(theFile) {
                                return function(e) {
                                    var binaryData = e.target.result;
                                    //Converting Binary Data to base 64
                                    var base64String = window.btoa(binaryData);
                                    //save into var globally string
                                    image = base64String;
                                };
                            })(f);
                            // Read in the image file as a data URL
                            reader.readAsBinaryString(f);
                        }
                        document.getElementById('files').addEventListener('change', handleFileSelect, false);
                    </script>

                </div>
                <div class="mb-3">
                    <a href="index.php" type="button" class="btn btn-primary form-control" style="cursor:url(https://cdn.custom-cursor.com/db/pointer/32/Infinity_Gauntlet_Pointer.png) , pointer!important ">Iniciate session</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        function changeCheckboxState() {
            var checkbox = document.getElementById("checkbox");
            checkbox.checked = !checkbox.checked;
        }
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script src="./assets/js/appLogin.js"></script>
    <script src="./assets/js/sweetalert2.all.min.js"></script>
    <script src="./assets/js/functions.js"></script>
</body>

</html>