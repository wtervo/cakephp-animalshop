<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Animalshop - A Shop for your Animalistic needs';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->script("jquery-3.4.1.min.js"); ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><a href="/cakeapp/">Animalshop</a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="left">
                <li><?= $this->Html->link("Dogs", "/products/dogs") ?></li>
                <li><?= $this->Html->link("Cats", "/products/cats") ?></li>
                <li><?= $this->Html->link("Birds", "/products/birds") ?></li>
                <li><?= $this->Html->link("Vermin", "/products/vermin") ?></li>
                <li><?= $this->Html->link("Reptiles", "/products/reptiles") ?></li>
                <li><?= $this->Html->link("Other", "/products/other") ?></li>
            </ul>
            <ul class="right">
                <li><?= $this->Html->link("Users", "/users") ?></li>
                <li>
                <?php echo $this->Html->link('Shopping Cart <span id="cart-counter">'.$count.'</span>',
                array('controller'=>'carts','action'=>'view'),array('escape'=>false));?>
                </li>
                <!-- when logged in as admin, show add product page -->
                <?php if($user_status === "admin"): ?>
                    <li><?= $this->Html->link("Add Product", "/products/add") ?></li>
                <?php endif; ?>
                <!-- login and registration shown only when user is not logged in -->
                <?php if($user_status === "not_logged"): ?>
                    <li><?= $this->Html->link("Register", "/users/add") ?></li>
                    <li><?= $this->Html->link("Login", "/users/login") ?></li>
                <?php endif; ?>
                <!-- when logged in, show username (links to the user page) and logout button -->
                <?php if($user_status === "logged_user" || $user_status === "admin"): ?>
                    <li><?= $this->Html->link(__("Logged in as {0}", $logged_username), ["action" => "../users/view", $logged_id]) ?></li>
                    <li><?= $this->Html->link("Logout", "/users/logout") ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
        <br />
        <p>Written in CakePHP - Oskari Tervo, 2019</p>
    </footer>
</body>
</html>
