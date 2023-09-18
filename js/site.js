$(document).ready(function() {

    validate("user_settings", "bio", {
        onBlur: "true",
        inputName: "Bio", // If you want the input name to be included in error message (recommended)
        min: 0,  // On number inputs min/max are the minimum and max number
        max: 128, // On text input types, min/max represent the min/max lengths of the string 
        regex: /^[a-zA-Z0-9, .\/]+$/, // If you want regex validation on the form field (i.e regex: "[a-zA-Z0-9+_. -]" for an email input)
        regexMessage: "Bio can only contain letters, numbers, and normal punctuation", // Leave out the period at the end It's auto added to end of message list
        blacklist: [], // Array of blacklisted strings/combinations for given input (May be expensive based on array length)
        nullable: "true" // Change this to true if it's okay if they leave out the field but you want to format it if they choose to fill it out
    });
    validate("user_settings", "birthday", {
        onBlur: "true",
        inputName: "Birthday", // If you want the input name to be included in error message (recommended)
        min: "01-01-1942",  // On number inputs min/max are the minimum and max number
        max: "01-01-2023", // On text input types, min/max represent the min/max lengths of the string 
        nullable: "true" // Change this to true if it's okay if they leave out the field but you want to format it if they choose to fill it out
    });
    validate("user_settings", "location", {
        onBlur: "true",
        inputName: "Location", // If you want the input name to be included in error message (recommended)
        min: 0,  // On number inputs min/max are the minimum and max number
        max: 56, // On text input types, min/max represent the min/max lengths of the string 
        regex: /^[a-zA-Z0-9, .\/]+$/, // If you want regex validation on the form field (i.e regex: "[a-zA-Z0-9+_. -]" for an email input)
        regexMessage: "Location can only contain letters, numbers, and normal punctuation", // Leave out the period at the end It's auto added to end of message list
        nullable: "true" // Change this to true if it's okay if they leave out the field but you want to format it if they choose to fill it out
    });
    validate("create_listing", "title", {
        onBlur: "true",
        inputName: "Title", // If you want the input name to be included in error message (recommended)
        min: 3,  // On number inputs min/max are the minimum and max number
        max: 32, // On text input types, min/max represent the min/max lengths of the string 
        regex: /^[a-zA-Z0-9, .\/!\':]+$/, // If you want regex validation on the form field (i.e regex: "[a-zA-Z0-9+_. -]" for an email input)
        regexMessage: "Title can only contain letters, numbers, and normal punctuation", // Leave out the period at the end It's auto added to end of message list
    });
    validate("create_listing", "description", {
        onBlur: "true",
        inputName: "Description", // If you want the input name to be included in error message (recommended)
        min: 3,  // On number inputs min/max are the minimum and max number
        max: 256, // On text input types, min/max represent the min/max lengths of the string 
        regex: /^[a-zA-Z0-9,\/!.\' :]+$/, // If you want regex validation on the form field (i.e regex: "[a-zA-Z0-9+_. -]" for an email input)
        regexMessage: "Description can only contain letters, numbers, and normal punctuation", // Leave out the period at the end It's auto added to end of message list
    });
    validate("create_listing", "price", {
        onBlur: "true",
        inputName: "Price", // If you want the input name to be included in error message (recommended)
    });
    validate("submit_bid", "bidAmount", {
        onBlur: "true",
        inputName: "Bid", // If you want the input name to be included in error message (recommended)
    });
    validate("leave_review", "review", {
        onBlur: "true",
        inputName: "Review", // If you want the input name to be included in error message (recommended)
        min: 0,  // On number inputs min/max are the minimum and max number
        max: 256, // On text input types, min/max represent the min/max lengths of the string 
        regex: /^[a-zA-Z0-9, .\/!\']+$/, // If you want regex validation on the form field (i.e regex: "[a-zA-Z0-9+_. -]" for an email input)
        regexMessage: "Your review can only contain letters, numbers, and normal punctuation", // Leave out the period at the end It's auto added to end of message list
        nullable: "true"
    });

});