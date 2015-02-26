<style>
    .form-control {
        max-width: 90%;
    }
</style>
<div class="container">
    <div class="breadcrumb_menu">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">My Career</li>
        </ol>
    </div>

    <div class="row">
        <?php if(!isset($email_sent)){?>
            <?php echo $this->Form->create('ChefCareer', array('type'=>'file')); ?>
            <div class="col-md-offset-1 col-md-22" >
                <fieldset>
                    <legend><?php echo __('Career with ChefGenie'); ?></legend>
                    <hr>
                    <?php
                    echo $this->Form->input('name', array('label'=>'Name *','div' => array('class' => 'form-group col-md-12'),'class' => 'form-control'));
                    echo $this->Form->input('sur_name', array('label'=>'Surname / Family Name *','div' => array('class' => 'form-group col-md-12'), 'type' => 'text', 'class' => 'form-control'));
                    echo $this->Form->input('date_of_birth', array('label'=>'Date of Birth *','div' => array('class' => 'form-group col-md-12'), 'type' => 'text', 'class' => 'form-control'));
                    echo $this->Form->input('place_birth', array('label'=>'Place of Birth *','div' => array('class' => 'form-group col-md-12'), 'class' => 'form-control'));
                    echo $this->Form->input('present_address', array('label'=>'Address *','div' => array('class' => 'form-group col-md-12'), 'type' => 'textarea', 'class' => 'form-control'));
                    //echo $this->Form->input('permanent_address', array('label'=>'Permanent Address *','div' => array('class' => 'form-group col-md-12'), 'type' => 'textarea', 'class' => 'form-control'));
                    echo $this->Form->input('nic', array('label'=>'NI No *','div' => array('class' => 'form-group col-md-12'),'class' => 'form-control'));
                    echo $this->Form->input('email', array('label'=>'Email *','div' => array('class' => 'form-group col-md-12'), 'type' => 'text', 'class' => 'form-control'));
                    echo $this->Form->input('phone_1', array('label'=>'Phone *','div' => array('class' => 'form-group col-md-12'), 'type' => 'text', 'class' => 'form-control'));
                    //echo $this->Form->input('phone_2', array('label'=>'Phone 2 *','div' => array('class' => 'form-group col-md-12'),'class' => 'form-control'));
                    echo $this->Form->input('mobile_1', array('label'=>'Mobile *','div' => array('class' => 'form-group col-md-12'), 'type' => 'text', 'class' => 'form-control'));
                    //echo $this->Form->input('mobile_2', array('label'=>'Mobile 2 *','div' => array('class' => 'form-group col-md-12'), 'type' => 'text', 'class' => 'form-control'));
                    //echo $this->Form->input('contact_address', array('label'=>'Contact Address *','div' => array('class' => 'form-group col-md-12'),'class' => 'form-control'));
                    ?>

                    <?php
                    echo $this->Form->input('gender', array('label'=>'Gender ','div' => array('class' => 'form-group col-md-12'), 'type' => 'select', 'class' => 'form-control','options'=>array(''=>'Select', 'Male'=>'Male', 'Female'=>'Female')));
                    echo $this->Form->input('nationality', array('label'=>'Nationality *','div' => array('class' => 'form-group col-md-12'), 'type' => 'text', 'class' => 'form-control'));
                    echo $this->Form->input('maritual_status', array('label'=>'Marital Status ','div' => array('class' => 'form-group col-md-12'), 'type' => 'select', 'class' => 'form-control','options'=>array(''=>'-Select-','Unmarried'=>'Unmarried','Married'=>'Married','Divorced'=>'Divorced','Widow'=>'Widow','Other'=>'Other')));
                    echo $this->Form->input('hobbies', array('label'=>'Interest / Hobbies ','div' => array('class' => 'form-group col-md-12'),'class' => 'form-control'));
                    echo $this->Form->input('extra_curricular_activities', array('label'=>'Extra Curricular Activities ','div' => array('class' => 'form-group col-md-12'), 'type' => 'textarea', 'class' => 'form-control'));
                    echo $this->Form->input('image', array('label'=>'Upload Resume (pdf/doc) *','div' => array('class' => 'form-group col-md-12'), 'type' => 'file', 'class' => ''));
                    ?>
                </fieldset>
                <hr>
                <?php echo $this->Form->input(' Submit ', array('label' => false, 'div' => array('class' => 'form-group col-md-24 text-center'), 'type' => 'submit', 'class' => 'btn btn-myshop','style'=>'width:20%;')); ?>
            </div>
        <?php }else{?>
            <div class="col-md-16" style="margin-left: 20%;">
                <fieldset>
                    <legend style=""><?php echo __('Career Response'); ?></legend>
                    <?php pr($error);?>
                    <p style="font-size: 15px;">
                        <?php if($email_sent == 1){?>
                            Your Job Profile has been submitted. Your Form ID is <strong><?php echo $form_id;?></strong> and Email is <strong><?php echo $form_email;?></strong>. Please keep your form id and email for future use. We will get back to you as soon as possible.
                        <?php }
                        if($email_sent == 0){?>
                            Failed to submit your job profile.Please try again.
                        <?php }
                        if($email_sent == 2){?>
                            Failed to submit your job profilel due to network/server problem.Please try again later.
                        <?php }?>
                    </p>
                    <div class="text-right">
                        <?php if($email_sent == 1){?><a href="<?php echo $this->webroot?>chefCareers/edit" class="btn btn-myshop">Edit</a><?php }?>
                        <?php if($email_sent == 0 || $email_sent == 2){?><a href="<?php echo $this->webroot?>chefCareers/myCareer" class="btn btn-myshop">Try Again</a><?php }?>
                        <a href="<?php echo $this->webroot?>" class="btn btn-myshop">ChefGenie Home</a>
                    </div>
                </fieldset>
            </div>
        <?php }?>
    </div>
</div>


<style>
        #ChefCareerMyCareerForm legend
        {
        	background: none repeat scroll 0 0 #e00000;
    		border: 1px solid #e00000;
    		border-radius: 7px;
    		color: #fff;
    		font-size: 16px;
    		padding: 5px 15px 5px 10px;
        }
</style>


<script>
    $( "#ChefCareerMyCareerForm" ).submit(function( event ) {

        if (!$( "#ChefCareerName" ).val() ) {
            alert( 'Username required.');
            $("#ChefCareerName").attr("placeholder", "Type your answer here");
            $( "#ChefCareerName" ).focus();
            event.preventDefault();
            return;
        }

        if (!$( "#ChefCareerSurName" ).val() ) {
            alert( 'Sur Name required.');
            $( "#ChefCareerSurName" ).focus();
            event.preventDefault();
            return;
        }
        if (!$( "#ChefCareerDateOfBirth" ).val() ) {
            alert( 'Date of Birth required.');
            $( "#ChefCareerDateOfBirth" ).focus();
            event.preventDefault();
            return;
        }
        if (!$( "#ChefCareerPlaceBirth" ).val() ) {
            alert( 'Place of Birth required.');
            $( "#ChefCareerPlaceBirth" ).focus();
            event.preventDefault();
            return;
        }
        if (!$( "#ChefCareerPresentAddress" ).val() ) {
            alert( 'Present Address required.');
            $( "#ChefCareerPresentAddress" ).focus();
            event.preventDefault();
            return;
        }
        
        if (!$( "#ChefCareerNic" ).val() ) {
            alert( 'NIC # required.');
            $( "#ChefCareerNic" ).focus();
            event.preventDefault();
            return;
        }
        if (!$( "#ChefCareerEmail" ).val() ) {
            alert( 'Email required.');
            $( "#ChefCareerEmail" ).focus();
            event.preventDefault();
            return;
        }

        if (!$( "#ChefCareerPhone1" ).val() ) {
            alert( 'Phone 1 required.');
            $( "#ChefCareerPhone1" ).focus();
            event.preventDefault();
            return;
        }
        
        if (!$( "#ChefCareerMobile1" ).val() ) {
            alert( 'Mobile 1 required.');
            $( "#ChefCareerMobile1" ).focus();
            event.preventDefault();
            return;
        }
        
        if (!$( "#ChefCareerNationality" ).val() ) {
            alert( 'Nationality required.');
            $( "#ChefCareerNationality" ).focus();
            event.preventDefault();
            return;
        }
        if (!$( "#ChefCareerImage" ).val() ) {
            alert( 'Please upload your resume in pdf format.');
            $( "#ChefCareerImage" ).focus();
            event.preventDefault();
            return;
        }

        if(isValidEmailAddress($( "#ChefCareerEmail" ).val()) == false)
        {
            alert( 'Invalid Email format.');
            $( "#ChefCareerEmail" ).focus();
            event.preventDefault();
            return;
        }

        return;
    });

    function isValidEmailAddress(emailAddress)
    {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }


</script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script type="text/javascript">
    $(function() {
        $( "#ChefCareerDateOfBirth" ).datepicker();
        $( "#ChefCareerDateOfBirth" ).datepicker("option", "dateFormat", "yy-mm-dd");
    });
</script>


