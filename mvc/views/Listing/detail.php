<?php $this->title('Listing Details'); ?>

<?php if (Model != null) :
    Model->getUser() ?>
<div class="max-w-[1080px] md:mt-5 p-5 mx-auto bg-[#212124] rounded">
    <div class="flex flex-col md:flex-row gap-5">
        <div class="md:w-[50%]">
            <div class="relative pb-[100%]">
                <img id="listing_preview" src="<?=browser_lp.Model->img_path?>" class="absolute inset-0 object-cover h-full w-full cursor-pointer" />
            </div>
        </div>
        <div class="flex flex-col w-full md:w-[50%]">
            <div class="mb-3 flex flex-row items-center justify-between w-full">
                <div class="flex flex-row gap-1">
                    <img src="<?=browser_pp.Model->user->profilePicture?>" class="w-6 h-6 rounded-full" />
                    <a href="<?=route('account', 'profile', Model->user->username)?>" class="underline"><?=Model->user->username?></a>
                </div>
                <div class="flex flex-row">
                    <?=Model->user->getRatingStars(4)?>
                </div>
            </div>
            <h1 class="font-bold text-2xl md:text-3xl"><?=Model->title?></h1>
            <div class="flex flex-row gap-1 items-center mt-1">
                <p class="rounded-lg bg-[#28282b] px-2 font-semibold w-min text-lg"><?=Model->getFormattedPrice(3)?></p>
                <?php if (Model->tags != 'all' && Model->tags != 'none') : ?>
                <p class="rounded-lg bg-[#28282b] px-2 font-semibold w-min text-lg"><?=Model->tags?></p>
                <?php endif; ?>
            </div>
            
            <p class="mt-3 text-lg"><?=Model->description?></p>
            <div class="self-end mt-5 md:mt-auto flex flex-row gap-2 items-center w-full">
                <?php
                if (User != null && User->id != Model->user_id) : 
                    if (Model->type === 'bidding') : 
                        Model->getBids();?>
                    <dialog id="openBid" class="text-white max-w-[640px] w-full bg-[#28282b] p-7 rounded open:backdrop:bg-black/75">
                        <div class="flex flex-col">
                            <div class="w-full flex flex-row items-center">
                                <h1 class="text-2xl font-bold w-5/6 truncate">Submit Bid on <?=Model->title?></h1>
                                <button class="close font-black text-lg p-2 w-1/6 text-end">&times;</button>
                            </div>
                            <div class="bg-[#212124] rounded w-full flex flex-col gap-2 h-[400px] overflow-y-auto mt-2 p-5">
                                <p class="text-center opacity-50">This bid's buyout price is set at <?=getFormattedPrice(3, Model->price)?></p>
                                <?php if (count(Model->bids) > 0) : 
                                    foreach(Model->bids as $bid) :
                                        $bid->getUser(); ?>
                                        <p class="flex flex-row items-center gap-3 md:gap-1 mx-auto text-sm md:text-base"><img class="w-8 h-8 md:w-4 md:h-4 rounded-full" src="<?=browser_pp.$bid->user->profilePicture?>" /> <?=$bid->user->username?> bid <?=getFormattedPrice(3, $bid->bid_amount)?> on <?=$bid->getDate()?></p>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p class="text-center opacity-50">There are currently no bids on this item!</p>
                                <?php endif; ?>
                            </div>
                            <div class="w-full mt-2">
                                <p id="bidAmount" class="text-red-600 text-center mb-1"></p>
                                <form method="post" id="submit_bid" class="w-full flex flex-col gap-2 md:gap-0 md:flex-row">
                                    <input type="hidden" name="listing_id" value="<?=Model->guid?>" />
                                    <input type="hidden" name="buyout" value="<?=Model->price?>" />
                                    <input class="w-full appearance-none md:w-3/5 p-2 bg-[#212124] text-center outline-none" name="bidAmount" placeholder="<?=getFormattedPrice(3, Model->price)?>" type="text" />
                                    <button class="w-full md:w-2/5 bg-red-600 font-black p-2" name="submit" type="submit">Submit Bid</button>
                                </form>
                            </div>
                        </div>
                    </dialog>
                    <button data-modal-target="openBid" class="w-full text-center p-3 bg-red-600 font-black flex flex-row justify-center items-center gap-1">Submit Bid</button>
                <?php else : ?>
                    <?php if (Cart::hasItem(Model->guid)) : ?>
                        <a href="<?=route('listing', 'removeFromCart', Model->guid)?>" class="w-full text-center p-3 bg-red-600 font-black flex flex-row justify-center items-center gap-1">Remove from Cart</a> 
                    <?php else : ?>
                        <a href="<?=route('listing', 'addToCart', Model->guid)?>" class="w-full text-center p-3 bg-red-600 font-black flex flex-row justify-center items-center gap-1">Add to Cart</a> 
                    <?php endif; ?>
                <?php endif; ?>
                <?php elseif (User != null && User->id === Model->user_id) : ?>
                   <?php if (Model->type === 'bidding') : 
                        Model->getBids();?>
                    <dialog id="openBid" class="text-white max-w-[640px] w-full bg-[#28282b] p-7 rounded open:backdrop:bg-black/75">
                        <div class="flex flex-col">
                            <div class="w-full flex flex-row items-center">
                                <h1 class="text-2xl font-bold w-5/6 truncate">Submit Bid on <?=Model->title?></h1>
                                <button class="close font-black text-lg p-2 w-1/6 text-end">&times;</button>
                            </div>
                            <div class="bg-[#212124] rounded w-full flex flex-col gap-2 h-[400px] overflow-y-auto mt-2 p-5">
                                <p class="text-center opacity-50">This bid's buyout price is set at <?=getFormattedPrice(3, Model->price)?></p>
                                <?php if (count(Model->bids) > 0) : 
                                    foreach(Model->bids as $bid) :
                                        $bid->getUser(); ?>
                                        <p class="flex flex-row items-center gap-3 md:gap-1 mx-auto text-sm md:text-base"><img class="w-8 h-8 md:w-4 md:h-4 rounded-full" src="<?=browser_pp.$bid->user->profilePicture?>" /> <?=$bid->user->username?> bid <?=getFormattedPrice(3, $bid->bid_amount)?> on <?=$bid->getDate()?></p>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p class="text-center opacity-50">There are currently no bids on this item!</p>
                                <?php endif; ?>
                            </div>
                            <div class="w-full mt-2">
                                <form method="post" action="<?=route('account', 'acceptbid')?>" class="w-full flex flex-col gap-2 md:gap-0 md:flex-row">
                                    <input type="hidden" name="listing_id" value="<?=Model->guid?>" />
                                    <button <?php if (count(Model->bids) == 0) { echo 'disabled'; } ?> class="w-full bg-red-600 font-black p-2" name="submit" type="submit">Accept Highest Bid</button>
                                </form>
                            </div>
                        </div>
                    </dialog>
                    <button data-modal-target="openBid" class="w-full text-center p-3 bg-red-600 font-black flex flex-row justify-center items-center gap-1">View Bids</button>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (User == null) : ?>
                    <p class="w-full md:text-center opacity-50">You need to <a class="text-red-600 opacity-100" href="<?=route('account', 'login')?>">login</a> to purchase or bid on items!</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
// A couple recommendation panels wouldn't hurt!
// I'm only showing these if there's more than 1 per recommendation
// Having a grid of 4 columns with only 1 filled is kinda lame
$userListings = Model->getUserListings(4);
if ($userListings['count'] > 1) : ?>
    <div class="max-w-[1080px] mt-5 p-5 mx-auto bg-[#212124] rounded">
        <h1 class="text-2xl font-extrabold">More listings by <?=Model->user->username?></h1>
    </div>
    <div class="max-w-[1080px] mx-auto mb-5">
        <div class="grid md:grid-cols-4 gap-5 mt-5">
        <?php foreach ($userListings['listings'] as $listing) { 
                $listing->getUser();
                if ($listing->user->suspended == 1 || $listing->sold == 1) {
                    // Skip all listings from suspended users
                    continue;
                }
        ?>
                <a href="<?=route('listing', 'detail', $listing->guid)?>" class="bg-[#212124] flex flex-col gap-2 p-3 hover:scale-[102%] hover:drop-shadow-lg transition duration-150 cursor-pointer self-start">
                    <div class="h-[200px]">
                        <img class="object-cover object-center w-full h-full" src="<?=browser_lp.$listing->img_path?>" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="rounded px-3 py-1 bg-[#28282b] text-center font-black"><?=$listing->getFormattedPrice(2)?></p>
                        <p class="font-semibold text-center truncate"><?=$listing->title?></p>
                    </div>
                </a>
        <?php 
            } 
        ?>
        </div>
    </div>
<?php endif; ?>
<?php
$relatedListings = Model->getRelatedListings(4);
if ($relatedListings['count'] > 1) : ?>
    <div class="max-w-[1080px] mt-5 p-5 mx-auto bg-[#212124] rounded">
        <h1 class="text-2xl font-extrabold">Listings related to <?=Model->tags?></h1>
    </div>
    <div class="max-w-[1080px] mx-auto mb-5">
        <div class="grid md:grid-cols-4 gap-5 mt-5">
        <?php foreach ($relatedListings['listings'] as $listing) { 
                $listing->getUser();
                if ($listing->user->suspended == 1 || $listing->sold == 1) {
                    // Skip all listings from suspended users
                    continue;
                }
        ?>
                <a href="<?=route('listing', 'detail', $listing->guid)?>" class="bg-[#212124] flex flex-col gap-2 p-3 hover:scale-[102%] hover:drop-shadow-lg transition duration-150 cursor-pointer self-start">
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
            } 
        ?>
        </div>
    </div>
<?php endif; ?>
<?php if (Model->type === 'bidding') : ?>
<script>
$(document).ready(function(){
    $('[name="bidAmount"]').on('input', function() {
        let sanitized = $(this).val().replace(/[^\d.,]/g, '');
        $(this).val(sanitized);
    });
    $('[name="bidAmount"]').on('blur', function() {
        let number = parseFloat($(this).val());
        if (number > 0) {
            let moneyFormat = number.toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD'
            });
            $(this).val(moneyFormat);
        }
    });
});
</script>
<?php endif; ?>
<?php else : ?>
    <div class="max-w-[1080px] md:mt-5 p-5 mx-auto">
        <div class="flex flex-col justify-center items-center gap-3">
            <p class="text-white text-4xl font-black">Sorry!</p>
            <p class="w-2/3 md:w-1/2 text-center">That listing is either deleted or was already purchased, click <a href="<?=route('home')?>" class="text-red-600">here</a> to go back to the home page!</p>
        </div>
    </div>
<?php endif; ?>
