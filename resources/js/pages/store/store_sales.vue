<template>

            <div class="col-sm-12 " style="position: relative;" >
                    <div class="card"  style="position: absolute; width: 65%;top: 50%;left: 50%;transform: translate(-50%, 50%);">

                      <div class="card-body grid-showcase">

                        <div class="row">
                          <div class="col" >
                              <span style="padding: 40px">
                              <router-link

                              :to="{name : 'product_store'}"
                              >
                                  <feather type="plus" style="cursor: pointer;"></feather><br />add new order
                                  </router-link>
                              </span>

                          </div>

                          <div class="col order-12"><span style="padding: 40px"><feather type="list" style="cursor: pointer;"></feather><br />sales  Records </span></div>
                        </div>



                      </div>
                    </div>
                </div>

</template>

<script>

export default {

}
</script>
