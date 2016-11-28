<div class="well container-fluid">
    <div class=" container row">
        <p>
                Congratulations, you've just completed the category {category}.
        </p>
        <p>
                <i>Show animation in which they receive a puzzle piece.</i>
        </p>
    </div>
    <div class="row">
        <div class="col-xs-3">
            <form action=<?php echo base_url().'index.php/resident/categories' ?> method="POST">
                <input class="btn btn-raised btn-default" type="submit" name="Categories" value="Do a new category!" style="size: 100%">
            </form>
        </div>
    </div>
</div>
