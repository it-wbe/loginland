<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
    .dropdown.dropdown-lg .dropdown-menu {
        margin-top: -1px;
        padding: 6px 20px;
    }
    .input-group-btn .btn-group {
        display: flex !important;
    }
    .btn-group .btn {
        border-radius: 0;
        margin-left: -1px;
    }
    .btn-group .btn:last-child {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    .btn-group .form-horizontal .btn[type="submit"] {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    .form-horizontal .form-group {
        margin-left: 0;
        margin-right: 0;
    }
    .form-group .form-control:last-child {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    @media screen and (min-width: 768px) {
        #adv-search {
            width: 500px;
            margin: 0 auto;
        }
        .dropdown.dropdown-lg {
            position: static !important;
        }
        .dropdown.dropdown-lg .dropdown-menu {
            min-width: 500px;
        }
    }
</style>
    <div class="input-group" id="adv-search" style="float: left; margin: 5px;">
    <input type="text" class="form-control searchGlobal" placeholder="Search..." />
    <div class="input-group-btn">
        <div class="btn-group" role="group">
            <div class="dropdown dropdown-lg">

                <div class="dropdown-menu dropdown-menu-right resultlist" role="menu">
                   result
                </div>

            </div>
            <button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
        </div>
    </div>
</div>
<script>
    $(function () {
        var activeButton = 0;
        var timeout;

        $(".searchGlobal").keydown(function (e) {
            if (timeout) {
                clearTimeout(timeout);
            }
            ///// up
            if($(this).val().length > 1)
                $('.resultlist').show();
            else
                $('.resultlist').hide();

            if (e.which == 38) {
                if (activeButton > 0) {
                    var all = $('.activeSearch').length;
                    var classThis = $('.activeSearch');
                    $(classThis[activeButton]).removeClass('selected');
                    activeButton--;
                    $(classThis[activeButton]).addClass('selected');
                }
            }
            /////enter
            else if (e.which == 13) {
                e.preventDefault();
                var classThis = $('.activeSearch');
                if ($(classThis[activeButton]).find('.linkUrl').attr('href')) {
                    var url = $(classThis[activeButton]).find('.linkUrl').attr('href');
                    window.location.href = url;
                }

                ///////down
            } else if (e.which == 40) {
                var all = $('.activeSearch').length;

                if ($('.activeSearch').length > 0 && activeButton < all - 1) {
                    var classThis = $('.activeSearch');
                    $(classThis[activeButton]).removeClass('selected');
                    activeButton++;
                    $(classThis[activeButton]).addClass('selected');
                }
                /////search
            } else {
                activeButton = 0;
                timeout = setTimeout(function () {
                    if ($(".searchGlobal").val().length > 0) {
                        $.get("index.php?route=extension/module/searchtop/ajax&query=" + $('#searchLive').val(), function (data) {
                            $("#searchbox").html(data);
                        });
                    }
                }, 500);

            }
        });

    });
</script>