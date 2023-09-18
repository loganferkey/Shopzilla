<?php $this->title('Home'); ?>

<div class="md:w-full lg:max-w-[1280px] p-5 mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-center p-4 bg-[#212124]">
        <a href="<?=route('listing', 'create')?>" class="bg-red-600 w-full mb-2 md:mb-0 md:w-auto text-center p-2 px-4 rounded font-black place-self-start">Create Listing</a>
        <form method="post" action="" id="listingSearch" class="flex flex-col md:flex-row items-center gap-1 place-self-end w-full md:w-auto">
            <select name="type" id="typeSelector" class="bg-[#28282b] p-1 h-10 border-b-2 w-[100%] md:w-auto border-gray-200 text-center">
                <option value="all" <?=Validator::ReSelect("type", "all", true)?>>All</option>
                <option value="purchase" <?=Validator::ReSelect("type", "purchase", false)?>>Purchase</option>
                <option value="bidding" <?=Validator::ReSelect("type", "bidding", false)?>>Bidding</option>
            </select>
            <select name="tags" id="tagSelector" class="bg-[#28282b] p-1 h-10 border-b-2 w-[100%] md:w-auto border-gray-200 text-center">
                <option value="all" <?=Validator::ReSelect("tags", "all", true)?>>All</option>
                <option value="automotive" <?=Validator::ReSelect("tags", "automotive", false)?>>Automotive</option>
                <option value="homedecor" <?=Validator::ReSelect("tags", "homedecor", false)?>>Home/Decor</option>
                <option value="tools" <?=Validator::ReSelect("tags", "tools", false)?>>Tools</option>
                <option value="electronics" <?=Validator::ReSelect("tags", "electronics", false)?>>Electronics</option>
                <option value="other" <?=Validator::ReSelect("tags", "other", false)?>>Other</option>
            </select>
            <div class="relative w-full md:w-auto">
                <input type="text" name="search" placeholder="Search listings..." value="<?=Validator::ReUse("search")?>" class="bg-[#28282b] h-10 text-center placeholder:text-center w-full outline-none border-b-2 border-gray-200 p-1" />
                <button type="submit" class="absolute right-[4px] top-[9px]"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg></button>
            </div>
        </form>
    </div>
    <div class="grid md:grid-cols-3 lg:grid-cols-5 gap-5 mt-5">
        <?php if (Model != null && Model['count'] > 0) : 
            foreach (Model['listings'] as $listing) { 
                $listing->getUser();
                if ($listing->user->suspended == 1 || $listing->sold == 1) {
                    // Skip all listings from suspended users
                    continue;
                }
        ?>
                <a href="<?=route('listing', 'detail', $listing->guid)?>" class="bg-[#212124] flex flex-col gap-2 p-3 w-full hover:scale-[102%] hover:drop-shadow-lg transition duration-150 cursor-pointer self-start">
                    <div class="h-[200px]">
                        <img class="object-cover object-center w-full h-full" src="<?=browser_lp.$listing->img_path?>" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="rounded px-3 py-1 bg-[#28282b] text-center font-black"><?=$listing->getFormattedPrice(2)?></p>
                        <p class="font-semibold text-center truncate"><?=$listing->title?></p>
                        <?php if ($listing->user != null) : ?>
                        <div class="grid grid-cols-2 justify-items-stretch gap-2">
                            <div class="flex flex-row gap-1 items-center justify-self-start overflow-hidden">
                                <img src="<?=browser_pp.$listing->user->profilePicture?>" class="w-4 h-4 rounded-full" />
                                <p class="text-sm truncate max-w-[135px]"><?=$listing->user->username?></p>
                            </div>
                            <div class="flex flex-row justify-self-end items-center">
                                <?=$listing->user->getRatingStars(4)?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </a>
        <?php 
            } endif; 
        ?>
    </div>
</div>

<script defer>
    $('#typeSelector').on('change', function() {
        $('#listingSearch').submit();
    });
    $('#tagSelector').on('change', function() {
        $('#listingSearch').submit();
    });
</script>