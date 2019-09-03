<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->user_id],
                ['confirm' => __('Are you sure you want to delete user "{0}"?', $user->username)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
            echo $this->Form->control('username');
            echo $this->Form->input('password', ["autocomplete" => "off"]); //I've tried values "new-password", false, "none" etc. and nothing works here (on Chrome)
            echo $this->Form->control('email');
            echo $this->Form->control('admin_status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
    <h4><b>I cannot for the life of me figure out why the form insist on autofilling the (hashed) password field even though I've tried everything. Please reset the password yourself when making changes.</b></h4>
</div>
