<template>

      <!-- Container-fluid starts-->
      <div class="container-fluid">

    <Breadcrumbs main="dashboard" title="add new  Order"/>
               <div class="row" >

                    <div class="col-lg-6" >
                        <div class="card card-mb-faq">
                            <div class="card-header faq-header">
                            </div>
                            <div class="card-body faq-body">


                                        <div class="col-lg-12 col-sm-12">
                                            <div class="form-row">
                                                    <div class="form-group col-sm-6">
                                                        <label for="inputEmail4">First Name</label>
                                                        <input
                                                        type="text"
                                                        id="firstName"
                                                        name="firstName"
                                                        class="form-control"
                                                        />
                                                        <div
                                                        class="invalid-feedback"
                                                        ></div>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label for="inputPassword4">Last Name</label>
                                                        <input
                                                        type="text"
                                                        id="lastName"
                                                        name="lastName"
                                                        class="form-control"
                                                        />
                                                    </div>
                                            </div>


                                        </div>
                                       <div class="col-lg-12 col-sm-12 " style="background-color:#F7F6F2;padding: 25px;">
                                           <div class="checkout-details">
                                               <div class="order-box">
                                                   <div class="title-box">
                                                       <div class="checkbox-title">
                                                           <h4>Product</h4><span>Total</span>
                                                        </div>
                                                    </div>
                                                    <ul class="qty">
                                                        <li>There are no products in cart</li>
                                                    </ul>
                                                    <ul class="sub-total">
                                                        <li>
                                                        Subtotal
                                                        <span class="count">$0.00</span>
                                                        </li>
                                                    </ul>
                                                    <ul class="sub-total">
                                                        <li>
                                                        Total
                                                        <span class="count">$0.00</span>
                                                        </li>
                                                        </ul>
                                                </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card card-mb-faq">
                            <div class="card-header faq-header">

                            </div>
                                <div class="card-body faq-body">
                                            <div class="row">
                                                <div class="col-xl-6 col-md-6">
                                                    <div class="prooduct-details-box">
                                                    <div class="media"><img class="align-self-center img-fluid img-60" src="" alt="#">
                                                        <div class="media-body ml-3">
                                                        <div class="product-name">
                                                            <h6><a href="#">Fancy Women's Cotton</a></h6>
                                                        </div>
                                                        <div class="price d-flex">
                                                            <div class="text-muted mr-2">Price</div>: 210$
                                                        </div>
                                                        <div class="avaiabilty">
                                                        </div>
                                                        <a class="btn btn-primary btn-xs" href="#">Processing</a><i class="close" data-feather="x"></i>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                        </div>
                        </div>
                    </div>
               </div >


      <!-- Container-fluid Ends-->
  </div>
</template>

<script>
  export default {
    data(){
      return {
      }
    },
    computed: {

    },
    methods:{

    }
  }
</script>

