<html>
    <head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <!--<script src="js/jquery-1.11.3.min.js" type="text/javascript" ></script>-->   
 <script>
            function printTreeNode(node) {  
               console.log(node);
               $('#tree').children().find('#node-'+node.parentID).append('<ul class="'+node.position+'"><li id="node-'+node.id+'" ><span>'+node.data+'</span></li></ul>');
            }
        </script>
    </head>    
    <body>
        <div id="tree">
            <ul>
                <li id="node-1">
                    <span>Root</span>
                </li>
            </ul>
        </div>

        <?php
        $tree = [
            [
                'parentID' => 1,
                'level' => 1,
                'position' => 'left',
                'data' => 'a',
                'id' => 2
            ],
            [
                'parentID' => 1,
                'level' => 1,
                'position' => 'right',
                'data' => 'b',
                'id' => 3
            ],
            [
                'parentID' => 2,
                'level' => 2,
                'position' => 'left',
                'data' => 'c',
                'id' => 4
            ],
            [
                'parentID' => 2,
                'level' => 2,
                'position' => 'right',
                'data' => 'd',
                'id' => 5
            ],
            [
                'parentID' => 3,
                'level' => 3,
                'position' => 'left',
                'data' => 'e',
                'id' => 6
            ],
            [
                'parentID' => 3,
                'level' => 3,
                'position' => 'right',
                'data' => 'f',
                'id' => 7
            ],
            [
                'parentID' => 4,
                'level' => 4,
                'position' => 'left',
                'data' => 'g',
                'id' => 8
            ],
            [
                'parentID' => 4,
                'level' => 4,
                'position' => 'right',
                'data' => 'g',
                'id' => 9
            ]
        ];

        printTree($tree);
        $root = [];

        function printTree(array $tree) {
            foreach ($tree as $node) {

                echo "<script>printTreeNode(".  json_encode($node).")</script>";
            }
        }
        ?>
        

    <body>
</html>