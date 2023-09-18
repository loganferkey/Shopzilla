<?php $this->title('AdminPanel - Users'); ?>

<div class="max-w-[960px] md:mt-5 p-5 mx-auto flex flex-row gap-3 bg-[#212124] rounded">
    <div class="w-1/6 h-full flex flex-col items-start justify-center">
        <a href="<?=route('admin')?>" class="p-2 hover:bg-[#28282b] text-center w-full border-b-2 border-gray-200">users</a>
        <a href="<?=route('admin', 'listings')?>" class="p-2 hover:bg-[#28282b] text-center w-full border-b-2 border-gray-200">listings</a>
    </div>
    <form class="w-5/6" method="post" action="<?=route('admin')?>">
        <div class="flex flex-col w-full gap-3">
            <?php
                if (Model != null && Model['count'] > 0) {
                    echo '<button type="submit" name="save_changes" class="bg-red-600 p-2 rounded font-bold">Save Changes</button>';
                    // Loop through all the users and display them, make sure to skip ourself/superadmins!
                    foreach (Model['users'] as $user) { if ($user->id === User->id || auth::isInRole($user->roles, 'superadmin')) { continue; } ?>
                        <div class="p-3 rounded flex flex-row items-center justify-between bg-[#28282b]">
                            <div class="flex flex-row items-center gap-3">
                                <img src="<?=browser_pp.$user->profilePicture?>" class="w-8 max-h-8 rounded-full" />
                                <a href="<?=route('account', 'profile', $user->username)?>" class="font-bold"><?=$user->username?><span class="opacity-75">#<?=$user->id?></span></a>
                            </div>
                            <div class="flex flex-row gap-5 items-center font-bold">
                                <select name="users[<?=$user->id?>][role]" class="font-bold bg-[#212124] text-white p-1 text-center rounded">
                                    <option value="user">User</option>
                                    <option value="admin" <?php if ($user->isAdmin()) { echo 'selected'; } ?>>Admin</option>
                                </select>
                                <div class="flex flex-row items-center gap-1">Suspended? <input name="users[<?=$user->id?>][suspended]" <?php if($user->suspended) { echo 'checked'; } ?> class="accent-red-600 ms-1" type="checkbox" /></div>
                            </div>
                        </div>
                    <?php }
                }?>
        </div>
    </form>
</div>