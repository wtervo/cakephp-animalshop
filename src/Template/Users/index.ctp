<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
    <h3><?= __('Users') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('username') ?></th>
                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('admin_status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->user_id) ?></td>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->email) ?></td>
                <td><?= h($user->created) ?></td>
                <td><?= h($user->admin_status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $user->user_id]) ?>
                    <!-- only the owner of the account can edit profiles -->
                    <?php if(isset($logged_id)): ?>
                        <?php if($user->user_id === $logged_id): ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->user_id]) ?>
                        <?php endif; ?>
                        <!-- only the owner of the account or admin can delete users -->
                        <?php if($user->user_id === $logged_id || $user_status === "admin"): ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->user_id], ['confirm' => __('Are you sure you want to delete user "{0}"?', $user->username)]) ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
