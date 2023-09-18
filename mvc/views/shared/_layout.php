<!DOCTYPE html>
<html lang="en" class="bg-[#28282b]">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=typography,aspect-ratio"></script>
    <link rel="stylesheet" href="<?=PROJ_ROOT?>css/style.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="<?=PROJ_ROOT?>js/components.js"></script>
    <script src="<?=PROJ_ROOT?>libs/jsvalidation.js"></script>
    <script src="<?=PROJ_ROOT?>js/site.js"></script>
    <style>@import url('https://fonts.googleapis.com/css2?family=Anuphan&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap');</style>
    <title><?=$this->title?></title>
    <script>const project_root = '<?=PROJ_ROOT?>';</script>
</head>
<body class="font-[Inter] text-gray-100 font-medium">
    <!-- The notification modal -->
    <dialog id="notifications" class="text-white max-w-[640px] w-full bg-[#28282b] p-7 rounded open:backdrop:bg-black/75">
        <div class="flex flex-col">
            <div class="w-full flex flex-row items-center">
                <h1 class="text-2xl font-bold w-5/6 truncate">Notifications</h1>
                <button class="close font-black text-lg p-2 w-1/6 text-end">&times;</button>
            </div>
            <div class="bg-[#212124] rounded w-full flex flex-col gap-2 h-[400px] overflow-y-auto mt-2 p-3">
                <?php if (User != null && Notification::count() > 0) :
                      foreach (Notification::getNotificationsFromUser(User->id) as $notif) : ?>
                      <a href="<?=route('account', 'notification', $notif->id)?>">
                        <div class="rounded p-3 bg-[#28282b] flex flex-row justify-between items-center w-full">
                            <p class="truncate"><?=$notif->title?></p>
                            <p class="text-end opacity-75"><?=$notif->getDate()?></p>
                        </div>
                      </a>
                <?php endforeach; 
                else : ?>
                <p class="text-center opacity-50 m-auto">Your notifications will appear here, buy something first!</p>
                <?php endif; ?>
            </div>
            <div class="w-full mt-2">
                <button class="close bg-red-600 font-black px-3 py-1 rounded float-right">Close</button>
            </div>
        </div>
    </dialog>
    <nav class="">
        <div class="flex justify-between items-center max-w-[1240px] h-20 mx-auto px-10">
            <!-- [Desktop Navbar] -->
            <div class="flex items-center gap-4">
                <!-- Primary Navbar -->
                <a href="<?=route('home')?>" class="font-black mr-5 text-2xl">SHOP<span class="text-red-600 font-black italic">ZILLA</span></a>
                <a href="<?=route('home')?>" class="transition hidden md:block duration-200 hover:text-red-600 font-bold">HOME</a>
            </div>
            <div class="hidden md:flex items-center gap-3">
                <?php if (User === null) : ?>
                    <!-- Secondary Navbar, Login/Register -->
                    <a href="<?=route('account','login')?>" class="transition duration-200 hover:text-red-600 font-bold">LOGIN</a>
                    <a href="<?=route('account','register')?>" class="transition duration-200 rounded bg-red-600 hover:bg-red-900 px-3 py-2 font-extrabold">SIGNUP</a>
                <?php else : ?>
                    <!-- User Dropdown When Logged In -->
                    <a href="<?=route('account', 'profile', User->username)?>"><img class="rounded-full w-6 h-6" src="<?=browser_pp.User->profilePicture?>" /></a>
                    <div class="dropdown-toggle relative flex flex-row items-center gap-2 cursor-pointer">
                        <p class="font-bold"><?=User->username?></p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-4 w-4 mt-1" viewBox="0 0 16 16"><path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" /></svg>
                        <div class="dropdown-menu hidden flex flex-col bg-white rounded-lg top-8 right-[-40%] absolute py-2 z-50">
                            <?php if (auth::isInRole(User->roles, 'admin')) : ?>
                                <a href="<?=route('admin')?>" class="flex flex-row gap-1 justify-center items-center px-6 py-1 text-gray-700 hover:bg-red-600 hover:text-white"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" /></svg> Admin</a>
                            <?php endif; ?>
                            <a href="<?=route('account','settings')?>" class="flex flex-row gap-1 justify-center items-center px-6 py-1 text-gray-700 hover:bg-red-600 hover:text-white"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 011.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.56.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.893.149c-.425.07-.765.383-.93.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 01-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.397.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 01-.12-1.45l.527-.737c.25-.35.273-.806.108-1.204-.165-.397-.505-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.107-1.204l-.527-.738a1.125 1.125 0 01.12-1.45l.773-.773a1.125 1.125 0 011.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg> Settings</a>
                            <a href="<?=route('account','profile')?>" class="flex flex-row gap-1 justify-center items-center px-6 py-1 text-gray-700 hover:bg-red-600 hover:text-white"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg> Profile</a>
                            <a href="<?=route('account','logout')?>" href="logout.php" class="flex flex-row gap-1 justify-center items-center px-6 py-1 text-gray-700 hover:bg-red-600 hover:text-white"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg> Logout</a>
                        </div>
                    </div>
                    <a href="#notifications" data-modal-target="notifications" class="rounded-full w-8 h-8 bg-[#212124] relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1 ms-1"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" /></svg>
                        <p class="absolute font-bold text-xs bottom-[-5px] right-[-5px] bg-red-600 px-[5px] rounded-full text-center"><?=Notification::count()?></p>
                    </a>
                    <a href="<?=route('account', 'cart')?>" class="rounded-full w-8 h-8 bg-[#212124] relative">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1 ms-1"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                        <p class="absolute font-bold text-xs bottom-[-5px] right-[-5px] bg-red-600 px-[5px] rounded-full text-center"><?=Cart::itemCount()?></p>
                    </a>
                <?php endif; ?>
            </div>
            <div class="block md:hidden">
                <!-- Mobile Hamburger Button -->
                <svg id="navbar-collapse" class="h-8 w-8 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </div>
            <!-- [Mobile Navbar] -->
            <div id="mobile-nav" class="fixed bg-[#28282b] left-[-100%] top-0 w-[60%] border-r-[3px] border-white ease-in-out py-6 duration-500 z-50 h-full">
                <a href="<?=route('home')?>" class="font-black text-2xl ps-10">SHOP<span class="text-red-600 font-black italic">ZILLA</span></a>
                <div class="flex flex-col uppercase min-w-full p-4">
                    <a href="<?=route('home')?>" class="p-4 border-b-2 border-gray-200 transition block md:hidden duration-200 hover:text-red-600 font-bold">HOME</a>
                    <?php if (User === null) : ?>
                        <a href="<?=route('account','login')?>" class="p-4 border-b-2 border-gray-200 transition block md:hidden duration-200 hover:text-red-600 font-bold">LOGIN</a>
                        <a href="<?=route('account','register')?>" class="p-4 transition block md:hidden duration-200 hover:text-red-600 font-bold">REGISTER</a>
                    <?php else : ?>
                        <?php if (auth::isInRole(User->roles, 'admin')) : ?>
                        <a href="<?=route('admin')?>" class="p-4 border-b-2 border-gray-200 transition block md:hidden duration-200 hover:text-red-600 font-bold">ADMIN</a>
                        <?php endif; ?>
                        <a href="<?=route('account','settings')?>" class="p-4 border-b-2 border-gray-200 transition block md:hidden duration-200 hover:text-red-600 font-bold">SETTINGS</a>
                        <a href="<?=route('account','profile')?>" class="p-4 border-b-2 border-gray-200 transition block md:hidden duration-200 hover:text-red-600 font-bold">PROFILE</a>
                        <a href="#notifications" data-modal-target="notifications" onclick="Components.CloseMobileNavbar()" class="p-4 flex flex-row items-center gap-2 border-b-2 border-gray-200 transition md:hidden duration-200 hover:text-red-600 font-bold">NOTIFS <p class="bg-red-600 px-2 py-[3px] text-sm rounded-lg text-center"><?=Notification::count()?></p></a>
                        <a href="<?=route('account','cart')?>" class="p-4 flex flex-row items-center gap-2 border-b-2 border-gray-200 transition md:hidden duration-200 hover:text-red-600 font-bold">CART <p class="bg-red-600 px-2 py-[3px] text-sm rounded-lg text-center"><?=Cart::itemCount()?></p></a>
                        <a href="<?=route('account','logout')?>" class="p-4 transition block md:hidden duration-200 hover:text-red-600 font-bold">LOGOUT</a>
                    <?php endif; ?>
                </div>    
            </div>
        </div>
    </nav>
    <?=$this->renderBody()?>
</body>
</html>