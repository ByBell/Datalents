$(document).ready(function () {
    renderTags('.hobby', '.hobbies', '.hobbies-list');
    renderTags('.skill', '.skills', '.skills-list');
});

function renderTags(input, destination, ul){
    $(input).keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if(keycode === 13) {
            e.preventDefault();
            $(destination).val($(destination).val()+$(input).val()+';');
            var tags = $(input).val().split(';');
            for(var i in tags){
                var li = document.createElement('li');
                li.classList.add('tag');
                li.innerHTML = tags[i];
                $(ul).append(li);
            }
            $(this).val('');
        }
    });
}