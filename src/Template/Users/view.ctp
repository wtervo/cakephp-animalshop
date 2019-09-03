<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if(isset($logged_id)): ?>
            <?php if($user->user_id === $logged_id): ?>
                <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->user_id]) ?> </li>
            <?php endif; ?>
            <?php if($user->user_id === $logged_id || $user_status === "admin"): ?>
                <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->user_id], ['confirm' => __('Are you sure you want to delete user "{0}"?', $user->username)]) ?> </li>
            <?php endif; ?>
        <?php endif; ?>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->user_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User Id') ?></th>
            <td><?= $this->Number->format($user->user_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Admin Status') ?></th>
            <td><?= $user->admin_status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
