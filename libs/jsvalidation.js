// Multi Use Function Library
// Should be seperated by function use but I don't care !!
// Logan Ferkey -> Sep. 29th 2022

// -------------------------------------------------------------------------------------------------------

// A function that allows you to toggle elements inside a div on click,
// For extendclassname supply the parent div's class named whatever you'd like i.e ('expandable')
// The child expandable name belongs to a class you put on the child of the parent div that you want to toggle i.e ('expanded' or 'toggleable')
// Add skip to the parent div class's to enable it to be expanded by default
function toggleExtendedInfo(extendClassName, childExpandableName, hideOnStart) {
    let elements = document.querySelectorAll(extendClassName);

    elements.forEach((ele) => {
        for (const child of ele.children) {
            if (child.classList.contains(childExpandableName)) {
                // This hides the elements by default so you don't have to style the class, see hideOnStart at the top
                // The default is true, so if you want them to show by default you have to set it to false,
                // Otherwise you can ommit the third parameter
                if ((hideOnStart === true || hideOnStart === undefined) && (!ele.classList.contains('skip'))) {
                    // only changes the display if it wasn't previously set,
                    // If you include the class 'skip' on any of these it won't hide it automatically
                        child.style.display = "none"; 
                }

                ele.addEventListener("click", () => {
                    child.style.display = child.style.display == "none" ? "block" : "none";
                });
            }
        }
    });
}

// ---------------------------------------------------------------------------
// ========= Attaches validation to any <input> element with options =========
// ---------------------------------------------------------------------------
// !!NOTICE!! If you have a number or string input, please specify type="text/number" on the input
// !!NOTICE!! Have a span element inside the parent div with the class of error on it, this is where the error messages will go
// !!NOTICE!! Place this inside a $(document).ready() to ensure all of the elements are loaded when validation is attached
// attachValidation("parentDivID", {
/*  onBlur: "true", -> onBlur also validates onBlur otherwise just on submit button click (recommended for text inputs)
    inputName: "username", // If you want the input name to be included in error message (recommended)
    min: 3,  // On number inputs min/max are the minimum and max number
    max: 15, // On text input types, min/max represent the min/max lengths of the string 
    regex: "regexpattern", // If you want regex validation on the form field (i.e regex: "[a-zA-Z0-9+_. -]" for an email input)
    regexMessage: "Password must contain a symbol, uppercase letter, and a lowercase letter", // Leave out the period at the end It's auto added to end of message list
    blacklist: ["password", "username"], // Array of blacklisted strings/combinations for given input (May be expensive based on array length)
    nullable: "true" // Change this to true if it's okay if they leave out the field but you want to format it if they choose to fill it out
})*/
// Example format for the HTML portion
// <div id="name">
//    <input />
//    <label></label> (If you have a label it doesn't matter where it is, the order of the elements in the parent div don't really matter)
//    <span></span>
// </div>

function validate(formID, inputName, options) {
    const form = document.getElementById(formID);
    const input = document.querySelector('[name="'+inputName+'"]');
    // This assumes your span has the id with the exact same name as the input
    const error = document.getElementById(inputName);
    if (form == null || error == null || input == null) {
        console.log("%c[jsvalidation]%c Elements missing, skipping...", "background: black; color: red;", "color: white;");
        return;
    }
    console.log("%c[jsvalidation]%c Validating "+inputName+" on form "+formID, "background: black; color: green;", "color: white;");

    let type = input.type;
    form.addEventListener("submit", (e) => {
        let errorMessages = [];
        if (options.nullable == undefined || options.nullable == "false") {
            if (input.value === '' || input.value == null) {
                errorMessages.push(options.inputName == undefined ? 'Field must not be blank' : options.inputName + " must not be blank");
            }
            checkV(input, input.value, errorMessages, options, type);
        }
        if (options.nullable === "true" && input.value.length > 0) {
            checkV(input, input.value, errorMessages, options, type);
        }
        if (errorMessages.length > 0) {
            e.preventDefault();
            error.innerText = errorMessages[0];
        } else {
            error.innerText = '';
        }
    });
    if (options.onBlur === "true") {
        input.addEventListener("blur", (e) => {
            let errorMessages = [];
            if (options.nullable == undefined || options.nullable == "false") {
                if (input.value == '' || input.value == null) {
                    errorMessages.push(options.inputName == undefined ? 'Field must not be blank' : options.inputName + " must not be blank");
                }
                checkV(input, input.value, errorMessages, options, type);
            }
            if ((options.nullable == "true" && input.value.length > 0)) {
                // Validation if the text isn't null
                checkV(input, input.value, errorMessages, options, type);
            }
            if (errorMessages.length > 0) { 
                error.innerText = errorMessages[0]; 
            } 
            else {  
                error.innerHTML = ''; 
            }
        });
    }
}

function checkV(input, inputValue, errors, options, type) {
    // Validate input based on type
    switch (type) {
        case "text":
            if (options.min) {
                if (inputValue.length < options.min) {
                    errors.push(options.inputName == undefined ? 
                        "Field must be longer than or "+options.min+" characters" : 
                        options.inputName+" must be longer than or "+options.min+" characters");
                }
            }
            if (options.max) {
                if (inputValue.length > options.max) {
                    errors.push(options.inputName == undefined ? 
                        "Field must be shorter than or "+options.max+" characters" : 
                        options.inputName+" must be shorter than or "+options.max+" characters");
                }
            }
            if (options.regex) {
                const regex = new RegExp(options.regex);
                if (!regex.test(inputValue)) {
                    if (options.regexMessage) {
                        errors.push(options.regexMessage);
                    }
                    else {
                        errors.push(options.inputName == undefined ?
                            "Field did not match required pattern" :
                            options.inputName+" did not match required pattern");
                    }
                }
            }
            break;
        case "number":
            // Make sure it's a number first
            if (isNaN(parseFloat(inputValue)) || !isFinite(inputValue)) {
                errors.push(options.inputName == undefined ? 
                    "Field must be a number" : 
                    options.inputName+" must be a number");
                    break;
            }
            if (options.min) {
                if (parseFloat(inputValue) < options.min) {
                    errors.push(options.inputName == undefined ? 
                        "Field must be greater than or "+options.min : 
                        options.inputName+" must be greater than or "+options.min);
                }
            }
            if (options.max) {
                if (parseFloat(inputValue) > options.max) {
                    errors.push(options.inputName == undefined ? 
                        "Field must be less than or "+options.max : 
                        options.inputName+" must be less than or "+options.max);
                }
            }
            break;
        case "date":
            const date = new Date(inputValue);
            if (isNaN(date)) {
                errors.push(options.inputName == undefined ? 
                    "Field must be a valid date" :
                    options.inputName+" must be a valid date");
                    break;
            }
            if (options.min) {
                const minDate = new Date(options.min);
                if (date < minDate) {
                    errors.push(options.inputName == undefined ? 
                        "Field must be later than or "+options.min : 
                        options.inputName+" must be later than or "+options.min);
                }
            }
            if (options.max) {
                const maxDate = new Date(options.max);
                if (date > maxDate) {
                    errors.push(options.inputName == undefined ? 
                        "Field must be earlier than or "+options.max : 
                        options.inputName+" must be earlier than or "+options.max);
                }
            }
            break;
        default:
            // Textarea and others will default here
            if (options.min) {
                if (inputValue.length < options.min) {
                    errors.push(options.inputName == undefined ? 
                        "Field must be longer than or "+options.min+" characters" : 
                        options.inputName+" must be longer than or "+options.min+" characters");
                }
            }
            if (options.max) {
                if (inputValue.length > options.max) {
                    errors.push(options.inputName == undefined ? 
                        "Field must be shorter than or "+options.max+" characters" : 
                        options.inputName+" must be shorter than or "+options.max+" characters");
                }
            }
            if (options.regex) {
                const regex = new RegExp(options.regex);
                if (!regex.test(inputValue)) {
                    if (options.regexMessage) {
                        errors.push(options.regexMessage);
                    }
                    else {
                        errors.push(options.inputName == undefined ?
                            "Field did not match required pattern" :
                            options.inputName+" did not match required pattern");
                    }
                }
            }
            break;
    }
}

// // Helper function for validation
// function checkV(input, inputValue, errors, options) 
// {
//     if (input.type != "number") {
//         if (options.min) {
//             if (inputValue.length < options.min) {
//                 errors.push(options.inputName == undefined ? 
//                     "Field must be longer than "+options.min+" characters" : 
//                     options.inputName+" must be longer than "+options.min+" characters");
//             }
//         }
//         if (options.max) {
//             if (inputValue.length > options.max) {
//                 errors.push(options.inputName == undefined ? 
//                     "Field must be shorter than "+options.max+" characters" : 
//                     options.inputName+" must be shorter than "+options.max+" characters");
//             }
//         }
//     }
//     if (input.type == "number") {
//         if (options.min) {
//             if (parseInt(inputValue) < options.min) {
//                 errors.push(options.inputName == undefined ? 
//                     "Field must be greater than "+options.min : 
//                     options.inputName+" must be greater than "+options.min);
//             }
//         }
//         if (options.max) {
//             if (parseInt(inputValue) > options.max) {
//                 errors.push(options.inputName == undefined ? 
//                     "Field must be less than "+options.max : 
//                     options.inputName+" must be less than "+options.max);
//             }
//         }
//     }

//     if (options.regex) {
//         const regex = new RegExp(options.regex);
//         if (!regex.test(inputValue)) {
//             if (options.regexMessage) {
//                 errors.push(options.regexMessage);
//             }
//             else {
//                 errors.push(options.inputName == undefined ?
//                     "Field did not match required pattern" :
//                     options.inputName+" did not match required pattern");
//             }
//         }
//     }
//     if (options.blacklist) {
//         for (const banned of options.blacklist) {
//             if (inputValue.toLowerCase() == banned.toLowerCase()) {
//                 errors.push(options.inputName == undefined ? 
//                     "Field cannot be named "+banned : 
//                     options.inputName+" cannot be named "+banned);
//             }
//         }
//     }
// }

// function validate(formID, parentDivID, options) 
// {
//     const form      = document.getElementById(formID);
//     const parentDiv = document.getElementById(parentDivID);
//     // Get the error text and input, I use span because it's an unlikely element to already be in your div with the input
//     const input     = parentDiv.querySelector('input');
//     const error     = parentDiv.querySelector('span');
//     // Skip if any of the elements are missing
//     if (form == null || error == null || input == null) {
//         console.log("Elements missing, skipping...");
//         return;
//     }

//     form.addEventListener("submit", (e) => {
//         let errorMessages = [];
//         if (options.nullable == undefined || options.nullable == "false") 
//         {
//             if (input.value === '' || input.value == null) 
//             {
//                 errorMessages.push(options.inputName == undefined ? 'Field must not be blank' : options.inputName + " must not be blank");
//             }
//             checkV(input, input.value, errorMessages, options);
//         }
//         if ((options.nullable == "true" && input.value.length > 0)) 
//         {
//             // Validation if the text isn't null
//             checkV(input, input.value, errorMessages, options);
//         }
//         if (errorMessages.length > 0) 
//         {
//             // Prevent form submission if there are any errors
//             e.preventDefault();
//             error.innerText = errorMessages[0];
//         } 
//         else 
//         { 
//             // Reset the error text
//             error.innerHTML = ''; 
//         }
//         // Option for onblur validation
//         if (options.onBlur == "true") 
//         {
//             input.addEventListener('blur', (e) => {
//                 let errorMessages = [];
//                 if (options.nullable == undefined || options.nullable == "false") 
//                 {
//                     if (input.value == '' || input.value == null) {
//                         errorMessages.push(options.inputName == undefined ? 'Field must not be blank' : options.inputName + " must not be blank");
//                     }
//                     checkV(input, input.value, errorMessages, options);
//                 }
//                 if ((options.nullable == "true" && input.value.length > 0)) 
//                 {
//                     // Validation if the text isn't null
//                     checkV(input, input.value, errorMessages, options);
//                 }
//                 if (messages.length > 0) 
//                 {
//                     // Only shows the first most message, which would be most important in this case (null field)
//                     error.innerText = messages[0];
//                 } 
//                 else 
//                 { 
//                     // Reset the error text
//                     error.innerHTML = ''; 
//                 }
//             });
//         }
//     });
// }