<div class="page-wrapper">
    <div class="container-fluid p-0">
        <div class="row">
        <div class="col-12">
            <div class="login-card">
              <div>
                <div class="login-main login-form-card">
                    <div  >

                          <div class="NewPasswordForm"  >
                          <h4 >  ENTER YOUR NEW PASSWORD </h4>
                              <p>  </p>
                                <form>
                                        <div class="form-group">

                                            <label class="col-form-label"> password </label>
                                            <input class="form-control">
                                            <small  style="color:red"  > the  password  faild   is required</small>
                                            <small  style="color:red"  > the  max length character is {{ $v.user.newPassword.password.$params.maxLength.max }}</small>
                                            <small  style="color:red" > the min lenght character is {{ $v.user.newPassword.password.$params.minLength.min }} </small>

                                        </div>

                                        <div class="form-group">

                                            <label class="col-form-label"> confirm password </label>
                                            <input class="form-control" >
                                            <small style="color:red"  > the confirm  faild  must same as password failde</small>

                                        </div>

                                    <button type="submit"  class="btn btn-primary pull btn-sm" >Reset Password</button>

                                </form>

                             </div>

                    </div>
                </div>
            </div>
        </div>
   </div>
</div>
</div>
</div>
