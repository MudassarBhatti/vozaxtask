<!doctype html>
<html lang="en">
<?php include './theme/header.php'; ?>
<?php include './theme/navbar.php' ?>
<body>

<div class="container-fluid">

    <div class="row">
        <div class="col-sm-12 col-lg-6 col-md-6" >
          <div class="jumbotron">
              <form id="dropzone" class="dropzone">

              </form>

          </div>

        </div>
        <div class="col-sm-12 col-lg-6 col-md-6" id="allFiles" style="text-align: center">


        </div>
    </div>


</div>





<?php include'./theme/footer.php' ?>
</body>
</html>


<script>

    let myDropzone = new Dropzone("#dropzone", {
        url: "post/post.php",
        acceptedFiles:".png,.jpg,.gif,.bmp,.jpeg",
        addRemoveLinks: true,
        renameFile: function (file) {
            return new Date().getTime() + '_' + file.name;
        },
        success: function()
        {
            getAllFiles();
        },

        removedfile: function(file) {
            var name = file.name;
            $.ajax({
                type: 'POST',
                url: 'delete.php',
                data: "id=" + name,
                dataType: 'html'
            });
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;

        }

        });

    function maketag(value)
    {
        return '<a data-fancybox="gallery" href="https://vozaxbucket-01.s3.us-west-002.backblazeb2.com/'+value.fileName +'" ><img src="https://vozaxbucket-01.s3.us-west-002.backblazeb2.com/'+value.fileName +'" style="max-width: 100px; max-height: 210px"></a>'
    }


    function getAllFiles()
    {

        $.ajax({
            type: 'POST',
            url: 'post/getAllFiles.php',
            beforeSend:function()
            {
                $('#allFiles').html('');
                $('#allFiles').html('<img src="images/Spinner-1s-200px.gif"> </img>');

            },
            success:function (result){
                result =   JSON.parse(result);
                   console.log(result.files);
               let value = ''
                value +=result.files.map(maketag)

                $('#allFiles').html(value);




            }
        });



    }


    $(document).ready(function(){
        getAllFiles();

    });

</script>