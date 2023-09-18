<?php $this->title('AdminPanel - Listings'); ?>

<div class="max-w-[960px] md:mt-5 p-5 mx-auto flex flex-row bg-[#212124] rounded">
    <div class="w-1/6 h-full flex flex-col items-start justify-center">
        <a href="<?=route('admin')?>" class="p-2 hover:bg-[#28282b] text-center w-full border-b-2 border-gray-200">users</a>
        <a href="<?=route('admin', 'listings')?>" class="p-2 hover:bg-[#28282b] text-center w-full border-b-2 border-gray-200">listings</a>
    </div>
    <form class="w-5/6" method="post" action="<?=route('admin', 'listings')?>">
        <div class="flex flex-col w-full gap-3">
            <?php
                if (Model != null && Model['count'] > 0) :
                    echo '<button type="submit" name="save_changes" class="bg-red-600 p-2 rounded font-bold">Save Changes</button>';
                    // Loop through all the users and display them, make sure to skip ourself/superadmins!
                    foreach (Model['listings'] as $listing) : ?>
                        <div class="p-3 rounded flex flex-row items-center justify-between bg-[#28282b]">
                            <div class="flex flex-row items-center gap-3">
                                <img src="<?=browser_lp.$listing->img_path?>" class="w-10 h-10" />
                                <a href="<?=route('listing', 'detail', $listing->guid)?>" class="font-bold truncate"><?=$listing->title?></a>
                            </div>
                            <div class="flex flex-row gap-5 items-center font-bold">
                                <input type="hidden" name="listings[<?=$listing->guid?>][user_id]" value="<?=$listing->user_id?>" />
                                <div class="flex flex-row items-center gap-1">Archived? <input name="listings[<?=$listing->guid?>][archived]" <?php if($listing->archived) { echo 'checked'; } ?> class="accent-red-600 ms-1" type="checkbox" /></div>
                                <div class="flex flex-row items-center gap-1">Sold <input name="listings[<?=$listing->guid?>][sold]" <?php if($listing->sold) { echo 'checked'; } ?> class="accent-red-600 ms-1" type="checkbox" /></div>
                            </div>
                        </div>
                    <?php endforeach;
                endif;?>
        </div>
    </form>
</div>