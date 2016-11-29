<head>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
        #div1 {
            width: 350px;
            height: 70px;
            padding: 10px;
            border: 1px solid #aaaaaa;
        }
        #drag{
            font-size: 12px;
        }
    </style>
    <script>
        $(function () {
            <?php foreach ($residents as $resident) { ?>
                $("#<?php echo ($resident->id); ?>").draggable(); //TODO
            <?php } ?>
        });
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("Text", ev.target.id);
        }

        function drop(ev) {
            var data = ev.dataTransfer.getData("Text");
            ev.target.appendChild(document.getElementById(data));
            ev.preventDefault();
        }
    </script>
</head>

<div class="row">
    <?php foreach ($residents as $resident) { ?>   
        <div id="<?php echo ($resident->id); ?>" class="ui-widget-content">

            <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 ">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <!--div id="drag" draggable="true" ondragstart="drag(event)"-->
                        <!--p value=<?php echo ($resident->id); ?>--> <?php echo ($resident->first_name); ?> </p>
                        <!--/div-->

                    </div>
                </div>
            </div>
        </div>
    <?php } ?>    
</div>


<div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
<div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)"></div>

