<?php $this->title('Profile');
?>

<div class="max-w-[1080px] bg-[#212124] rounded p-5 mx-auto md:mt-5">
    <?php if (Model != null && Model->suspended == 0) : ?>
    <div class="flex flex-row justify-between md:justify-start md:gap-10">
        <img src="<?=browser_pp.Model->profilePicture?>" class="w-32 h-32 rounded-full" />
        <div class="flex flex-col items-end md:items-start">
            <p class="font-bold text-2xl flex flex-row items-center"><?=Model->username?><span class="opacity-75"><?='#'.Model->id?></span> <?php if (Model->isAdmin()) { echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="ms-1 w-6 h-6 text-red-600">
                <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 00-1.032 0 11.209 11.209 0 01-7.877 3.08.75.75 0 00-.722.515A12.74 12.74 0 002.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 00.374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 00-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08zm3.094 8.016a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" /></svg>'; } ?></p>
            <div class="flex flex-row gap-[1px] mb-3">
                <?php
                 for($i = 0; $i < 5; $i++) {
                    if ($i < round(Model->rating)) {
                        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6 text-red-600">
                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.007 5.404.433c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.433 2.082-5.006z" clip-rule="evenodd" />
                      </svg>';
                    } else {
                        echo '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>';
                    }
                 }
                ?>
            </div>
            <p class="opacity-90 text-end md:text-start"><?=Model->bio?></p>
        </div>
    </div>
</div>
<div class="max-w-[1080px] mx-auto mt-3 flex flex-col-reverse md:flex-row gap-3">
    <div class="w-full md:w-1/2 flex flex-col gap-3">
        <div class="bg-[#212124] p-5">
            <p class="text-center font-extrabold text-lg">Recent Listings</p>
        </div>
        <?php Model->getListings();
        if (Model->listings != null && Model->listings['count'] > 0) :
            foreach (Model->listings['listings'] as $l) : 
                if ($l->archived === 1 || $l->sold === 1) { continue; } ?>
                <a href="<?=route('listing', 'detail', $l->guid)?>" class="flex flex-row items-center gap-5 bg-[#212124] p-3 transition duration-100 hover:scale-[101%]">
                    <div class="h-[75px] w-[75px] flex-shrink-0">
                        <img class="object-cover object-center w-full h-full" src="<?=browser_lp.$l->img_path?>" />
                    </div>
                    <div class="flex flex-col truncate flex-grow gap-1">
                        <p class="w-full truncate font-bold"><?=$l->title?></p>
                        <p class="rounded px-3 py-1 bg-[#28282b] text-center font-black w-min"><?=$l->getFormattedPrice(3)?></p>
                    </div>
                </a>
        <?php endforeach; endif; ?>
    </div>
    <div class="p-5 bg-[#212124] w-full md:w-1/2 flex flex-col gap-3">
        <p class="text-center font-extrabold text-lg">Recent Reviews</p>
        <?php Model->getReviews();
        if (Model->reviews != null) :
            foreach (Model->reviews as $r) : ?>
            <?php $r->getReviewer(); $r->getListing(); ?>
                <div class="flex flex-col gap-1 w-full">
                    <div class="flex flex-row gap-2 w-full items-center">
                        <img class="w-6 h-6 rounded-full" src="<?=browser_pp.$r->reviewer->profilePicture?>" />
                        <a href="<?=route('account', 'profile', $r->reviewer->username)?>" class="font-bold"><?=$r->reviewer->username?></a>
                    </div>
                    <div class="flex flex-row">
                        <?=$r->getRatingStars(6)?>
                    </div>
                    <p class="w-full truncate opacity-50 text-sm">Review for <?=$r->listing->title?></p>
                    <p><?=$r->review?></p>
                </div>
        <?php endforeach; endif; ?>
    </div>
</div>
<?php else : ?>
    <div class="flex flex-col justify-center items-center gap-3">
        <p class="text-white text-4xl font-black">Sorry!</p>
        <p class="w-2/3 md:w-1/2 text-center">That user is either suspended or doesn't exist, click <a href="<?=route('home')?>" class="text-red-600">here</a> to go back to the home page!</p>
    </div>
</div>
<?php endif; ?>