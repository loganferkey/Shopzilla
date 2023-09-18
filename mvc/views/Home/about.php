<?php $this->title('Components'); ?>

<div class="max-w-[1080px] p-5 mx-auto">
    <button data-modal-target="myModal" class="bg-red-600 p-3 font-black">Toggle Modal</button>
    <dialog id="myModal" class="bg-[#212124] text-white shadow-lg transition-all backdrop:bg-black/25 open:backdrop:bg-black/75 duration-200">
        <div class="flex flex-col w-[500px] gap-3">
            <div class="p-5 header flex flex-row justify-between items-center border-b border-gray-300">
                <p class="text-lg font-extrabold">Modal Header</p>
                <button class="font-black text-lg p-2 close">&times;</button>
            </div>
            <div class="body p-5">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed, rem commodi non fugit adipisci quisquam enim odio. Incidunt doloribus omnis, obcaecati officiis, porro alias nobis vitae, laboriosam illum a perspiciatis.</p>
            </div>
            <hr/>
            <div class="p-5 footer flex flex-row justify-end items-center gap-3 pt-3">
                <button class="close p-3 bg-gray-500 font-black">Commit Changes</button>
                <button class="close p-3 bg-red-600 font-black">Close</button>
            </div>
        </div>
    </dialog>
</div>
