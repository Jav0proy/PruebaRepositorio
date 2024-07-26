<!DOCTYPE html>
<html>
<head>
<style>
div {
  border: 1px solid black;
  padding:8px;
}
</style>
</head>
<body>

<h2>Metodo getElementsByClassName()</h2>

<p>
   
<div class="ejemplo">
  <p>Prueba 1</p>
</div>
<br>
<div class="ejemplo">
  <p>Prueba 2</p>
</div>
<br>
<div class="ejemplocolor">
  <p>Prueba 3</p>
</div>

<script>
const collection = document.getElementsByClassName("ejemplo");
for(var i =0; i < collection.length; i++){
collection[i].style.backgroundColor = "red";
}
</script>

</body>
</html>