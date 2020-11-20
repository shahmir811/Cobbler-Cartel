<template>
<div>
  <div class='landing-page-wrapping-div'>
    </div>
      <div class="landing-page-centered-div">
        <h1>Welcome to Cobbler Cartel CMS</h1>
      </div>
</div>
  
</template>

<script>
export default {
  name: "Landing",
}
</script>

<style lang="scss">

@import "../../styles/styles.scss"; 

.landing-page-wrapping-div {
  background-image: url("./leather-shoe.png");
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover; 
  opacity: 0.5;
  width: 102%;
  height: 92vh;
  padding: 0px;
  margin: 0px;
  margin-left: -15px;
  // position: relative;
}

.landing-page-centered-div {
  position: absolute;
  opacity: 1 !important;
  background-color: $BROWN-12;
  color: $GREY-2;
  padding: 50px;
  top: 35%;
  left: 30%;
}

</style>