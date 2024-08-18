console.log('this file works');

$(document).ready(function(){
    // redirecting to home page when clicked on home icon
    $('nav .fa-home').click(function(){
        window.location.href = "homepage.php";
    });
    // showing sidebar on click of menu icon
    $('nav .fa-bars').click(function(){
        $('.sidebar').animate({width: 'toggle'},'fast','linear');
    });
    // sidebar sections toggle
    $('.sidebar-title').click(function(){
        $(this).next('ul').slideToggle('slow').addClass('toggle');
        $(this).find('i').toggleClass('fa-angle-down fa-angle-right');
    });
    // changing sidebar links css when file gets changed
    $('.sidebar ul li ').click(function(){
        $('.sidebar ul li').removeClass('active');
        $(this).toggleClass('active');
    });
    // getting current day,date and month
    let now = new Date().toLocaleDateString('en-us', { weekday:"short", month:"short",day:"numeric"});
    console.log(now)
    $('.heading small').text(now);

    // add task button js
    $('.add-task .add-task-head').click(function(){
        $(this).hide();
        $('.add-task .add-task-body').addClass('show');
    });
    $('.add-task .add-task-body #one').click(function(){
        $('.add-task .add-task-head').show();
        $('.add-task .add-task-body').removeClass('show');
        if ($('.add-task .add-task-body .input').value("")){
            $('.add-task .add-task-body .addBtn').attr("disabled", true);
        }
    });

    // completed task js
    $('.single-task .todo .checkbox').click(function(){
        $(this).next('div').toggleClass('done');
        $(this).children('i').toggleClass('fa-circle-o fa-check-circle-o');
    });
    // deleting tasks
    $('.fa-trash').click(function(){
        var dId = $(this).attr('attr-id');
        $('#delId').val(dId);
        console.log(dId);
        $('#deleteModal').css('display', 'block');
    });
    // editing tasks
    $('.fa-edit').click(function(){
        var eId = $(this).attr('attr-id');
        $('#editId').val(eId);
        console.log(eId);
        
        $.get( "function.php", { id: eId, getEditData: 'getEdit' } ).done(function( data ){
            console.log(data);
            var res = JSON.parse(data);
        
            var gid = res[0]['Sno'];
            var gtext = res[0]['task-name'];
            var gdes = res[0]['task-desc'];
            var gdue = res[0]['due-date'];
            var gpriority = res[0]['priority'];
            $('#editId').val(gid);
            $('#editName').val(gtext);
            $('#editDesc').val(gdes);
            $('#editDuedate').val(gdue);
            $('#editPriority').val(gpriority);

        });
        $('#editModal').css('display', 'block');
        
    });
    // modal js
    $('.modalBtn').click(function(){
        $('.modal').css('display', 'block');
    });
    $('.modalClose').click(function(){
        $('.modal').css('display', 'none');
    });
    // user info modal
    $('.fa-user').click(function(){
        $('#userInfoModal').css('display', 'block');
        console.log('clicked');
    });
    // showing delete account modal
    $('#userInfoModal .delAccount').click(function(){
        $('#deleteAccountModal').css('display', 'block');
        $('#userInfoModal').css('display', 'none');
    });
    // hiding delete account modal
    $('#deleteAccountModal #return, #deleteAccountModal .modalClose, #deleteAccountModal #one').click(function(){
        $('#deleteAccountModal').css('display', 'none');
        $('#userInfoModal').css('display', 'block');
    });
    // disable form submit on enter key
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
      });
});
