<?php $this->title('Create Listing'); ?>

<form method="post" id="create_listing" enctype="multipart/form-data" action="">
    <input type="hidden" name="user_id" value="<?=User->id?>" />
    <div class="max-w-[960px] md:mt-5 p-5 mx-auto bg-[#212124] rounded">
        <div class="flex flex-col md:flex-row gap-5">
            <div class="md:w-3/5">
                <div class="relative pb-[100%]">
                    <img id="listing_preview" src="<?=browser_lp.'default.png'?>" class="absolute inset-0 object-cover h-full w-full" />
                    <div class="absolute bottom-5 right-5 w-12 h-12 overflow-hidden rounded-full bg-[#28282b]">
                        <input name="listingpicture" id="listingpicture" type="file" accept=".jpg,.jpeg,.png,.gif" class="inset-0 opacity-0 absolute" />
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ms-[10px] mt-[10px] w-7 h-7"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-full md:w-2/5">
                <div class="mb-3 flex flex-col w-full gap-1">
                    <label>Title</label>
                    <input type="text" name="title" placeholder="Toyota 4Runner" class="appearance-none bg-[#28282b] p-2 border border-[#3b3b3e] outline-none" />
                    <span id="title" class="text-red-600 text-center"></span>
                </div>
                <div class="mb-3 flex flex-col w-full gap-1">
                    <label>Description</label>
                    <textarea name="description" placeholder="New/Used, Runs like brand new, only 720k miles, 35K OBO" class="appearance-none bg-[#28282b] p-2 border border-[#3b3b3e] outline-none"></textarea>
                    <span id="description" class="text-red-600 text-center"></span>
                </div>
                <div class="mb-3 flex flex-col w-full gap-1">
                    <label>Listing Type</label>
                    <div class="grid w-full gap-2 grid-cols-2">
                        <div>
                            <input type="radio" id="purchase" name="type" value="purchase" class="hidden peer" <?=Validator::ReCheck("type", "purchase", true)?> />
                            <label for="purchase" class="inline-flex items-center justify-center w-full p-1 text-gray-500 border border-gray-600 cursor-pointer peer-checked:border-white peer-checked:bg-red-600 peer-checked:text-white hover:text-gray-600 hover:bg-gray-300">
                            Purchase
                            </label>
                        </div>
                        <div>
                            <input type="radio" id="bidding" name="type" value="bidding" class="hidden peer" <?=Validator::ReCheck("type", "bidding", false)?> />
                            <label for="bidding" class="inline-flex items-center justify-center w-full p-1 text-gray-500 border border-gray-600 cursor-pointer peer-checked:border-white peer-checked:bg-red-600 peer-checked:text-white hover:text-gray-600 hover:bg-gray-300">
                            Bidding
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 flex flex-col w-full gap-1">
                    <label>Price ($)</label>
                    <p class="text-xs opacity-25">On bids this is the price where the bid wins the item</p>
                    <input name="price" type="text" placeholder="$35,000.00" class="appearance-none bg-[#28282b] p-2 border border-[#3b3b3e] outline-none" />
                    <span id="price" class="text-red-600 text-center"></span>
                </div>
                <div class="mb-3 flex flex-col w-full gap-1">
                    <label>Tags</label>
                    <div class="flex flex-row flex-wrap gap-1">
                        <div>
                            <input type="radio" name="tags" id="none" value="none" class="hidden peer" <?=Validator::ReCheck("tags", "none", true)?> />
                            <label for="none" class="inline-flex items-center justify-center px-3 py-1 rounded-lg text-gray-500 border border-gray-600 cursor-pointer peer-checked:border-white peer-checked:bg-red-600 peer-checked:text-white hover:text-gray-600 hover:bg-gray-300">
                            None
                            </label>
                        </div>
                        <div>
                            <input type="radio" name="tags" id="automotive" value="automotive" class="hidden peer" <?=Validator::ReCheck("tags", "automotive", false)?> />
                            <label for="automotive" class="inline-flex items-center justify-center px-3 py-1 rounded-lg text-gray-500 border border-gray-600 cursor-pointer peer-checked:border-white peer-checked:bg-red-600 peer-checked:text-white hover:text-gray-600 hover:bg-gray-300">
                            Automotive
                            </label>
                        </div>
                        <div>
                            <input type="radio" name="tags" id="homedecor" value="homedecor" class="hidden peer" <?=Validator::ReCheck("tags", "homedecor", false)?> />
                            <label for="homedecor" class="inline-flex items-center justify-center px-3 py-1 rounded-lg text-gray-500 border border-gray-600 cursor-pointer peer-checked:border-white peer-checked:bg-red-600 peer-checked:text-white hover:text-gray-600 hover:bg-gray-300">
                            Home/Decor
                            </label>
                        </div>
                        <div>
                            <input type="radio" name="tags" id="tools" value="tools" class="hidden peer" <?=Validator::ReCheck("tags", "tools", false)?> />
                            <label for="tools" class="inline-flex items-center justify-center px-3 py-1 rounded-lg text-gray-500 border border-gray-600 cursor-pointer peer-checked:border-white peer-checked:bg-red-600 peer-checked:text-white hover:text-gray-600 hover:bg-gray-300">
                            Tools
                            </label>
                        </div>
                        <div>
                            <input type="radio" name="tags" id="electronics" value="electronics" class="hidden peer" <?=Validator::ReCheck("tags", "electronics", false)?> />
                            <label for="electronics" class="inline-flex items-center justify-center px-3 py-1 rounded-lg text-gray-500 border border-gray-600 cursor-pointer peer-checked:border-white peer-checked:bg-red-600 peer-checked:text-white hover:text-gray-600 hover:bg-gray-300">
                            Electronics
                            </label>
                        </div>
                        <div>
                            <input type="radio" name="tags" id="other" value="other" class="hidden peer" <?=Validator::ReCheck("tags", "other", false)?> />
                            <label for="other" class="inline-flex items-center justify-center px-3 py-1 rounded-lg text-gray-500 border border-gray-600 cursor-pointer peer-checked:border-white peer-checked:bg-red-600 peer-checked:text-white hover:text-gray-600 hover:bg-gray-300">
                            Other
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit" class="bg-red-600 p-3 w-full font-bold">Create Listing</button>
            </div>
        </div>
    </div>
</form>

<script defer>
    $('[name="price"]').on('input', function() {
        let sanitized = $(this).val().replace(/[^\d.,]/g, '');
        $(this).val(sanitized);
    });
    $('[name="price"]').on('blur', function() {
        let number = parseFloat($(this).val());
        if (number > 0) {
                let moneyFormat = number.toLocaleString('en-US', {
                style: 'currency',
                currency: 'USD'
            });
            $(this).val(moneyFormat);
        }
    });
    $('input[name="listingpicture"]').on('change', function() {
        let input = this;
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#listing_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
</script>