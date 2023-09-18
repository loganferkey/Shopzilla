<?php $this->title('Leave a review'); 
    Model->getListing();
    Model->listing->getUser();
?>

<style>
  .rating {
    display: inline-flex;
    flex-direction: row-reverse;
    justify-content: center;
    align-items: center;
  }

  .rating input {
    display: none;
  }

  .rating label {
    cursor: pointer;
    color: #ddd;
    margin-left: 5px;
  }

  .rating label:before {
    content: "\2605";
    font-size: 32px;
  }

  .rating input:checked ~ label,
  .rating input:checked ~ label ~ input ~ label {
    color: rgb(220, 38, 38);
  }
</style>

<div class="max-w-[500px] md:mt-5 p-5 mb-5 mx-auto bg-[#212124] rounded">
    <div class="text-center">
        <h1 class="text-2xl md:text-3xl font-black mb-1">Leave a Review!</h1>
        <p class="text-sm md:text-base opacity-75">This review is for your purchase of <?=Model->listing->title?></p>
        <p class="text-sm md:text-base opacity-75">And will be featured on <?=Model->listing->user->username?>'s profile<span class="text-red-600 opacity-100">*</span></p>
    </div>
    <form method="post" id="leave_review">
        <input type="hidden" name="lister_id" value="<?=Model->listing->user->id?>" />
        <input type="hidden" name="reviewer_id" value="<?=User->id?>" />
        <input type="hidden" name="listing_id" value="<?=Model->listing->guid?>" />
        <div class="rating w-full mb-1">
            <input type="radio" id="star5" name="rating" value="5" />
            <label for="star5"></label>
            <input type="radio" id="star4" name="rating" value="4" />
            <label for="star4"></label>
            <input type="radio" id="star3" name="rating" value="3" />
            <label for="star3"></label>
            <input type="radio" id="star2" name="rating" value="2" />
            <label for="star2"></label>
            <input type="radio" checked id="star1" name="rating" value="1" />
            <label for="star1"></label>
        </div>
        <div class="flex flex-col gap-1 text-center mb-2">
            <textarea style="min-height: 100px;" class="appearance-none w-full placeholder:text-center bg-[#28282b] p-2 border border-[#3b3b3e] outline-none" type="text" name="review" placeholder="Write your review here"></textarea>
            <span id="review" class="text-red-600 text-center"></span>
        </div>
        <button class="font-black bg-red-600 rounded px-4 py-2 w-full">Submit Review</button>
    </form>
</div>