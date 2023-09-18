<?php $this->title('Login'); ?>

<div class="mx-auto max-w-[450px] md:mt-20 px-10 py-6">
    <form class="w-full" method="post" action="<?=route('account','login')?>">
        <div id="error" class="text-red-600 flex flex-col justify-center items-center">
            <?php if (Model !== null) : ?>
                <p class="text-lg font-bold mb-2"><?=Model?></p>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <input name="username" type="text" placeholder="Username" class="w-full text-center appearance-none placeholder:opacity-50 placeholder:text-white leading-tight py-2 px-3 bg-transparent border-b-[3px] border-white outline-2 outline-offset-2 outline-red-600" />
        </div>
        <div class="mb-3">
            <input name="password" type="password" placeholder="Password" class="w-full text-center appearance-none placeholder:opacity-50 placeholder:text-white leading-tight py-2 px-3 bg-transparent border-b-[3px] border-white outline-2 outline-offset-2 outline-red-600" />
            <div class="mt-3 flex flex-row gap-1 items-center justify-center">
                <p class="text-sm opacity-50">Don't have an account?</p>
                <a href="<?=route('account','register')?>" class="opacity-100 text-red-600 text-sm">Register</a>
            </div>
        </div>
        <div>
            <button type="submit" class="w-full font-extrabold rounded px-3 py-2 bg-red-600 hover:bg-red-900 transition duration-200" name="submit">Login</button>
        </div>
    </form>
</div>