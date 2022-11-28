<?php
    session_start();

    $action = $_REQUEST['action'];

    if(!empty($action)){
        require_once './proccess.php';
        $obj = new Process();
    }


    if($action == 'users' && !empty($_POST)){
        $name = $_POST['sing_name'];
        $email = $_POST['sing_email'];
        $password = password_hash($_POST['sing_password'],PASSWORD_DEFAULT);
        $phone = $_POST['sing_phone'];

        $user = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'phone' => $phone
        ];

        $adduser = $obj->add($user,'usuario');
        if(isset($adduser)){
            echo json_encode($user);
        }
        
    }

    if($action == 'login'){
        $email = $_POST['sing_up_email'];
        $password = $_POST['sing_up_password'];
        $loguser = $obj->log('usuario','email','password',$email,$password);
        if(!empty($loguser)){
            echo json_encode($loguser);
        }else{
            echo "Usuario o Contraseña incorrecta";
        }
        
    }

    if($action == 'citas'){
        $fecha = $_REQUEST['fecCit'];
        $cita = $obj->datesDist('citas','dateCit',$fecha);
        if(!empty($cita)){
            echo json_encode($cita);
        }else{
            echo "no hay citas disponibles para este dia";
        }
        
    }

    if($action == 'information'){
        $username = $_REQUEST['userMail'];
        $informatio = $obj->records('usuario','email',$username);
        echo json_encode($informatio);

    }

    if($action == 'show_Citas'){
        $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
        $limit = 5;
        $start = ($page - 1) * $limit;

        $citas = $obj->getRows('citas',$start, $limit);
        if (!empty($citas)) {
            $citaslist = $citas;
        } else {
            $citaslist = [];
        }
        $total = $obj->getCount('citas');
        $citasArr = ['count' => $total, 'citas' => $citaslist];
        echo json_encode($citasArr);
    }

    if($action == 'addCit'){
        $fecha = $_POST['cit_date'];
        $horaIni = $_POST['cit_time_start'];
        $horaEnd = $_POST['cit_time_end'];

        $cita = [
            'dateCit' => $fecha,
            'timeStart' => $horaIni,
            'timeEnd' => $horaEnd 
        ];

        $addCit = $obj->addCit($cita,'citas');
        if(isset($addCit)){
            echo json_encode($cita);
        }
    }

    /* MOSTRAR CITAS DEL DIA - ADMIN */
    if($action == 'show_Citas_Today'){
        $page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
        $limit = 5;
        $start = ($page - 1) * $limit;

        $fecha = $_REQUEST['day_today'];
        $citas = $obj->datesDis('registros','citdat',$fecha,$start, $limit);
        if (!empty($citas)) {
            $citaslist = $citas;
        } else {
            $citaslist = [];
        }
        $total = $obj->getCountCit('registros','citdat',$fecha);
        $citasArr = ['count' => $total, 'registros' => $citaslist];
        echo json_encode($citasArr);
    }

    if($action == 'profile'){
        $user = $_REQUEST['user'];
        $informatio = $obj->records('usuario','email',$user);
        echo json_encode($informatio);
    }

    if($action == 'save_Citas'){
        $fecha = $_REQUEST['date'];
        $horaIni = $_REQUEST['timeStart'];
        $horaFin = $_REQUEST['timeEnd'];
        $name = $_REQUEST['name'];
        $email = $_REQUEST['email'];
        $phone = $_REQUEST['telefono'];
        $id = $_REQUEST['id'];
        $available = 0;

        $cita = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'citdat' => $fecha,
            'timeStart' => $horaIni,
            'timeEnd' => $horaFin
        ];

        $citupdate = [
            'available' => $available
        ];

        $addCit = $obj->addCit($cita,'registros');
        if(isset($addCit)){
            $upCit = $obj->update($citupdate,$id,'citas');
            echo json_encode($cita);
        }

    }

    if($action == 'profileCit'){
        $user = $_REQUEST['user'];
        $date = $_REQUEST['date'];
        $citas = $obj->datesUse('registros','email',$user,'citdat',$date);
        if(!empty($citas)){
            echo json_encode($citas);
        }else{
            echo "Aun no tienes citas";
        }
    }

    if($action == 'addProduct'){
        $name = $_POST['product_name'];
        $price = $_POST['product_price'];
        $photo = $_FILES['file'];
        $image = '';
            $image = $obj->uploadPhoto($photo);
            $product = [
                'name' => $name,
                'price' => $price,
                'photo' => $image,
            ];
        $add = $obj->addother($product,'producto');
        echo json_encode($add);
    }
   
    if($action == 'Predeterminado_Citas'){
        $fecha = $_REQUEST['date'];
        $primero = [
            'timeStart' => "10:00:00",
            'timeEnd' => "10:30:00",
            'dateCit' => $fecha
        ];
        $primero = $obj->addother($primero,'citas');
        echo json_encode($primero);

        $segundo = [
            'timeStart' => "10:30:00",
            'timeEnd' => "11:00:00",
            'dateCit' => $fecha
        ];
        $segundo = $obj->addother($segundo,'citas');

        $tercero = [
            'timeStart' => "11:00:00",
            'timeEnd' => "11:30:00",
            'dateCit' => $fecha
        ];
        $tercero = $obj->addother($tercero,'citas');

        $cuarto = [
            'timeStart' => "11:30:00",
            'timeEnd' => "12:00:00",
            'dateCit' => $fecha
        ];
        $primero = $obj->addother($cuarto,'citas');

        $quinto = [
            'timeStart' => "12:00:00",
            'timeEnd' => "12:30:00",
            'dateCit' => $fecha
        ];
        $quinto = $obj->addother($quinto,'citas');

        $sexto = [
            'timeStart' => "12:30:00",
            'timeEnd' => "13:00:00",
            'dateCit' => $fecha
        ];
        $sexto = $obj->addother($sexto,'citas');

        $septimo = [
            'timeStart' => "13:00:00",
            'timeEnd' => "13:30:00",
            'dateCit' => $fecha
        ];
        $septimo = $obj->addother($septimo,'citas');

        $octavo = [
            'timeStart' => "13:30:00",
            'timeEnd' => "14:00:00",
            'dateCit' => $fecha
        ];
        $octavo = $obj->addother($octavo,'citas');

        $noveno = [
            'timeStart' => "14:00:00",
            'timeEnd' => "15:00:00",
            'dateCit' => $fecha
        ];
        $noveno = $obj->addother($noveno,'citas');

        $decimo = [
            'timeStart' => "16:00:00",
            'timeEnd' => "16:30:00",
            'dateCit' => $fecha
        ];
        $decimo = $obj->addother($decimo,'citas');

        $decimoprimero = [
            'timeStart' => "16:30:00",
            'timeEnd' => "17:00:00",
            'dateCit' => $fecha
        ];
        $decimoprimero = $obj->addother($decimoprimero,'citas');

        $decimosegundo = [
            'timeStart' => "17:00:00",
            'timeEnd' => "18:00:00",
            'dateCit' => $fecha
        ];
        $decimosegundo = $obj->addother($decimosegundo,'citas');

        $decimotercero = [
            'timeStart' => "18:30:00",
            'timeEnd' => "19:00:00",
            'dateCit' => $fecha
        ];
        $decimotercero = $obj->addother($decimotercero,'citas');

        $decimocuarto = [
            'timeStart' => "19:30:00",
            'timeEnd' => "20:00:00",
            'dateCit' => $fecha
        ];
        $decimocuarto = $obj->addother($decimocuarto,'citas');

    }

    if($action == 'show_products_admin' || $action == 'show_products' ){
        $showProduct = $obj->mostrar('producto');
        echo json_encode($showProduct);
    }

    if($action == 'show_users_admin'){
        $showUsers = $obj->mostrar('usuario');
        echo json_encode($showUsers);
    }

    if($action == 'delcitas'){
        $indice = $_REQUEST['indice'];
        $citas = $obj->deleteRow('citas',$indice);
        echo json_encode($citas);
        exit();
    }

    if($action == 'show_edit_product'){
        $indice = $_REQUEST['no'];
        $prodcut = $obj->datesDist('producto','id',$indice);
        echo json_encode($prodcut);
    }


?>