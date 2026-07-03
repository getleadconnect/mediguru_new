<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Touch-enabled Drag'n'drop Table Sorter Example</title>
    <link href="{{asset('css/drag-style.css')}}" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="{{asset('js/table-row-sorter.js')}}"></script>
</head>
<body>

<style>
    body { background: #fafafa; }
table.sorting-table {cursor: move;}
table tr.sorting-row td {background-color: #8b8;}
.container { margin: 50px auto; }
table tr, td
{
	border:1px solid red;
}

table tr
{
	background-color:#e4e4e4;
	min-height:50px !important;
}
.div-style{
	min-height:30px;
	padding:10px;
}
table#sample_table:hover
{
	cursor:pointer;
}
</style>
<div class="container">

   <table id="sample_table" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th colspan="3">Basic Sorting</th>
        </tr>
    </thead>
    <tbody>
        <tr><td><div class="div-style">Sample Content 1</div></td></tr>
        <tr><td><div class="div-style">Sample Content 2</div></td></tr>
        <tr><td><div class="div-style">Sample Content 3</div></td></tr>
        <tr><td><div class="div-style">Sample Content 4</div></td></tr>
        <tr><td><div class="div-style">Sample Content 5</div></td></tr>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <!--<td colspan="3"><button type="button" onclick="RowSorter.destroy('#sample_table');">Destroy RowSorter</button></td>-->
        </tr>
    </tfoot>
</table>
</div>

<script type="text/javascript">
RowSorter("#sample_table");
</script>

</body>
</html>