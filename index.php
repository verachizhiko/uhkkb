<?php
require_once "db.php";
if(!empty($_POST)) {
    $extra = explode(",", $_POST['extra']);
    $req1 = $pdo->prepare("insert into attendance (idmonth, name, daycount, idextra, sum) values(?,?,?,?,?)");
    $req1->execute([
        $_POST['month'],
        $_POST['name'],
        $_POST['daycount'],
        $extra[0],
        $_POST['sum'],
    ]);
    $success = 'Заявка принята';
}
$req2 = $pdo->query("select * from month");
$months = $req2->fetchAll();
$req3 = $pdo->query("select * from extra");
$extras = $req3->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Каляка-маляка</title>
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <div class="container">
            <p class="gray">Рассчёт стоимости</p>
            <form method="post">
                <label for="month">Месяц</label>
                <select name="month" id="month">
                    <?php foreach($months as $month): ?>
                        <option value="<?= $month['id'] ?>"><?= $month['name'] ?></option>
                    <?php endforeach ?>
                </select>
                <label for="dayprice">Стоимость 1 дня</label>
                <input type="text" name="dayprice" id="dayprice" value="600" readonly="" />
                <label for="name">ФИО ребёнка</label>
                <input type="text" name="name" id="name" required/>
                <label for="daycount">Количество дней</label>
                <input
                    type="number"
                    name="daycount"
                    id="daycount"
                    value="1"
                    min="1"
                    max="100"
                    required
                />
                <label for="extra">Дополнительная услуга</label>
                <select name="extra" id="extra">
                    <?php foreach($extras as $extra): ?>
                        <option value="<?= $extra['id'] ?>,<?= $extra['price'] ?>"><?= $extra['name'] ?></option>
                    <?php endforeach ?>
                </select>
                <label for="sum">Сумма к оплате за месяц</label>
                <input type="text" name="sum" id="sum" readonly="" />
                <input type="submit" value="Сохранить" class="gray button">
            </form>
            <?php if(isset($success)): ?>
                <div class="success"><?= $success ?></div>
            <?php endif ?>
        </div>
        <script src="js/script.js"></script>
    </body>
</html>
