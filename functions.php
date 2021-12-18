<?php

/* В данном коде присутствует Спагетти код и нарушение принципа SOLID */

session_start();

if(!isset($_SESSION['screen'])){
    $_SESSION['screen'] = 1;
    $_SESSION['data'] = [];
}

if($_POST['data'] == 'Отправить'){
    unset($_POST['data']);
    $_SESSION['data']['Экран ' . $_SESSION['screen']] = $_POST;
    $_SESSION['screen'] += 1;
}

function pic($screen=1){
    $screen = is_numeric($screen) ? $screen : 1;
    $images = scandir('images');
    $images = array_slice($images, 2);

    switch($screen){
        case 1:
            echo '<div class="img-block"><h2>Выберете 2 картинки, которые нравятся и 2, которые не нравятся.</h2>';
            for($i = 0; $i < 8; $i++){
                echo '
                <div class="input">
                    <img src="/images/'.$images[$i].'">
                    <label class="">Нравится
                        <input type="checkbox" name="img_nice[]" value="'.$images[$i].'">
                    </label>
                    <label class="">Не нравится
                        <input type="checkbox" name="img_bad[]" value="'.$images[$i].'">
                    </label>
                </div>';
                    
            }
            echo '</div>';
            break;
            case 2:
                echo '<div class="img-block"><h2>Выберете 2 картинки, которые нравятся и 2, которые не нравятся.</h2>';
                for($i = 8; $i < 16; $i++){
                    echo '
                    <div class="input">
                    <img src="/images/'.$images[$i].'">
                    <label class="">Нравится
                        <input type="checkbox" name="img_nice[]" value="'.$images[$i].'">
                    </label>
                    <label class="">Не нравится
                        <input type="checkbox" name="img_bad[]" value="'.$images[$i].'">
                    </label>
                </div>';
                }
                echo '</div>';
                break;
    }

}