<?php $this->title('Settings'); ?>

<div class="max-w-[520px] bg-[#212124] md:mt-5 rounded p-5 mx-auto">
    <form id="user_settings" method="post" enctype="multipart/form-data" action="<?=route('account', 'settings')?>">
        <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
        <input type="hidden" name="id" value="<?=Model->id?>" />
        <div class="flex flex-row gap-3 justify-center mb-5">
            <div class="relative">
                <img id="pp_preview" src="<?=browser_pp.Model->profilePicture?>" class="w-24 h-24 rounded-full" />
                <div class="absolute bottom-0 right-0 w-8 h-8 overflow-hidden rounded-full bg-[#28282b]">
                    <input name="profilepicture" id="profilepicture" type="file" accept=".jpg,.jpeg,.png,.gif" class="inset-0 opacity-0 absolute" />
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mt-1 ms-1 inset-0 absolute pointer-events-none"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" /><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" /></svg>
                </div>
            </div>
            <div class="flex flex-col items-center justify-center">
                <p class="font-bold text-lg"><?=Model->username?><span class="opacity-75"><?='#'.Model->id?></span></p>
                <p class="text-sm"><?=Model->email?></p>
            </div>
        </div>
        <div class="mb-3 flex flex-col items-center">
            <label class="font-bold text-sm mb-1">Biography</label>
            <textarea maxlength="128" placeholder="Write a brief description about yourself..." name="bio" class="appearance-none placeholder:text-center bg-[#28282b] w-full border-b-2 min-h-[75px] border-gray-200 outline-1 outline-gray-200 p-2"><?=User->bio?></textarea>
            <span id="bio" class="text-red-600 text-center"></span>
        </div>
        <div class="mb-3 flex flex-col items-center">
            <label class="font-bold text-sm mb-1">Birthday</label>
            <input name="birthday" type="date" value="<?=User->birthday?>" class="appearance-none text-white text-center bg-[#28282b] w-full border-b-2 border-gray-200 outline-1 outline-gray-200 p-2" />
            <span id="birthday" class="text-red-600 text-center"></span>
        </div>
        <div class="mb-3 flex flex-col items-center">
            <label class="font-bold text-sm mb-1">Location</label>
            <input name="location" placeholder="USA" value="<?=User->location?>" class="appearance-none placeholder:text-center text-center bg-[#28282b] w-full border-b-2 border-gray-200 outline-1 outline-gray-200 p-2" />
            <span id="location" class="text-red-600 text-center"></span>
        </div>
        <button disabled type="submit" id="submit" class="w-full bg-red-600 opacity-50 p-3 font-black rounded">Save Changes</button>
    </form>
</div>

<script defer>
    // TODO: Make save changes clickable on any field changing, change opacity to 100, remove disable attr
    // Changes profile picture preview to your selected image
    $('input[name="profilepicture"]').on('change', function() {
        let input = this;
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#pp_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        enableButton();
    });

    function enableButton() { $('#submit').attr('disabled', false).removeClass('opacity-50'); }
    $('[name="birthday"]').on('keydown', enableButton);
    $('[name="birthday"]').on('change', enableButton);
    $('[name="location"]').on('keydown', enableButton);
    $('[name="bio"]').on('keydown', enableButton);

</script>