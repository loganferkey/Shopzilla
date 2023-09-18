<?php $this->title('Cart'); ?>

<div class="max-w-[1080px] md:mt-5 p-5 mb-5 mx-auto bg-[#212124] rounded">
    <h1 class="text-3xl font-black">Shopping Cart</h1>
</div>
<?php if (Model == null || Cart::itemCount() == 0) : ?>
    <div class="max-w-[1080px] md:mt-5 p-5 mx-auto bg-[#212124] rounded">
        <p class="text-center">Your cart is currently empty, head to the <a href="<?=route('home', 'index')?>" class="text-red-600">home page</a> to add some items!</p>
    </div>
<?php else : $totalPrice = 0; ?>
    <div class="max-w-[1080px] flex flex-col gap-5 mx-auto">
    <?php foreach(Model as $item) : 
        $item->getUser(); ?>
        <div class="w-full bg-[#212124] rounded gap-3 md:gap-0 flex flex-col md:flex-row md:justify-between p-5">
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-2/3">
                <div class="w-full h-32 md:w-1/4 md:h-36 overflow-hidden"><img class="object-cover object-center w-full h-full" src="<?=browser_lp.$item->img_path?>" /></div>
                <div class="flex flex-col gap-1 w-full md:w-3/4">
                    <p class="text-xl font-extrabold truncate"><?=$item->title?></p>
                    <div class="flex flex-col md:flex-row gap-1 md:gap-2 items-start md:items-center">
                        <p class="flex flex-row items-center gap-1"><img class="rounded-full w-5 h-5" src="<?=browser_pp.$item->user->profilePicture?>" /> <?=$item->user->username?></p>
                        <div class="flex flex-row items-center">
                            <?=$item->user->getRatingStars(4)?>
                        </div>
                    </div>
                    <p><?=$item->description?></p>
                </div>
            </div>
            <div class="flex flex-col gap-2 justify-start items-end w-full md:w-1/3">
                <p class="rounded px-3 py-1 bg-[#28282b] text-center font-black w-full md:w-min"><?=$item->getFormattedPrice(3)?></p>
                <a href="<?=route('account', 'removeFromCart', $item->guid)?>" class="rounded bg-red-600 px-3 py-1 text-center font-black w-full md:w-min">Remove</a>
            </div>
        </div>
    <?php $totalPrice += $item->price; endforeach; ?>
    </div>
    <div class="max-w-[1080px] flex flex-col md:justify-between md:flex-row items-center gap-1 mt-5 p-5 mx-auto bg-[#212124] rounded">
        <p class="text-2xl font-black">Total Price: <?=getFormattedPrice(3, $totalPrice)?></p>
        <a href="<?=route('account', 'purchaseCart')?>" class="bg-red-600 text-xl px-4 py-2 text-center rounded font-black flex flex-row gap-1 items-center w-full md:w-auto justify-center">Purchase Cart <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg></a>
    </div>
<?php endif; ?>
