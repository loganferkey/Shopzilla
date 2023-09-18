<?php $this->title('Register'); ?>

<div class="mx-auto max-w-[450px] md:mt-20 px-10 py-6">
    <form class="w-full" id="register" method="post" action="<?=route('account','register')?>">
        <div class="mb-3 flex flex-col items-center gap-2">
            <input name="email" type="email" placeholder="Email" class="w-full text-center appearance-none placeholder:opacity-50 placeholder:text-white leading-tight py-2 px-3 bg-transparent border-b-[3px] border-white outline-2 outline-offset-2 outline-red-600" />
            <span id="email" class="text-red-600"></span>
        </div>
        <div class="mb-3 flex flex-col items-center gap-2">
            <input name="username" type="text" placeholder="Username" class="w-full text-center appearance-none placeholder:opacity-50 placeholder:text-white leading-tight py-2 px-3 bg-transparent border-b-[3px] border-white outline-2 outline-offset-2 outline-red-600" />
            <span id="username" class="text-red-600"></span>
        </div>
        <div class="mb-3 flex flex-col items-center gap-2">
            <input name="password" type="password" placeholder="Password" class="w-full text-center appearance-none placeholder:opacity-50 placeholder:text-white leading-tight py-2 px-3 bg-transparent border-b-[3px] border-white outline-2 outline-offset-2 outline-red-600" />
            <span id="password" class="text-red-600"></span>
        </div>
        <div>
            <button type="submit" class="w-full font-extrabold rounded px-3 py-2 bg-red-600 hover:bg-red-900 transition duration-200" name="submit">Create Account</button>
        </div>
    </form>
</div>