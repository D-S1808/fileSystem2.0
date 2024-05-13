// Waiting for DOM Elements to be loaded and hiding keyWordBox by default and declaring an array selectedKeyWords to store and show selected keyWords.
$(document).ready(function () {
    $('#keyWordBox').hide();
    const selectedKeyWords = [];

    // Function to add event listener to each badge and remove the badge from selectedKeyWords array and update the selectedKeyWordsContainer
    function badgeEventListener() {
        $('#selectedKeyWordsContainer *').click(function () {
            let index = selectedKeyWords.indexOf($(this).text());
            if (index > -1) {
                selectedKeyWords.splice(index, 1);
            }

            let badges = selectedKeyWords.map((keyWord) => {
                return `<div class="badge text-bg-primary user-select-none">${keyWord}</div>`;
            }).join('');

            $('#selectedKeyWordsContainer').html(badges);
            badgeEventListener();
        })
    }

    // Ajax GET to retrieve the keyWords from the getKeyWord.php and adding them to the list-group (keyWordBox)
    $('#formGroupInput').on('input', function () {
        var keyWord = $(this).val();
        if (keyWord.length > 1) {
            $.ajax({
                url: "getKeyWord.php",
                type: "GET",
                data: { term: keyWord },
                success: function (data) {
                    var keyWords = data.data;
                    var keyWordsHtml = '';
                    for (var i = 0; i < keyWords.length; i++) {
                        keyWordsHtml += '<button type="button" class="list-group-item list-group-item-action">' + keyWords[i] + '</button>';
                    }
                    $('#keyWordBox').html(keyWordsHtml).show();

                    // adding EventListener click to keyWordBox and getting text from keyWords buttons in keyWordBox, if already in Box leave instanceof, else add it to selectedKeyWords
                    $('#keyWordBox button').click(function () {
                        if (selectedKeyWords.indexOf($(this).text()) === -1) {
                            selectedKeyWords.push($(this).text());
                        }

                        // making the selected keyWords to Badges and displaying them
                        let badges = selectedKeyWords.map((keyWord) => {
                            return `<div class="badge text-bg-primary user-select-none">${keyWord}</div>`;
                        }).join('');
                        $('#selectedKeyWordsContainer').html(badges);
                        badgeEventListener();
                    })
                }
            });

            // if nothing is written hide keyWordsBox
        } else {
            $('#keyWordBox').hide();
        }
    });
});

$(document).ready(function () {
    // Ajax POST to send the selectedKeyWords to the savedKeyWord.php
    $('#addKeyWord').click(function () {
        $.ajax({
            url: "setKeyWord.php",
            type: "POST",
            data: { term: keyWord },
            success: function (data) {
                alert(data);
            }
        });
    });
}
);

// $(document).ready(function () {
//     bsCustomFileInput.init();
// });
