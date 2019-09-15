<div class="container">

    <!-- Include Flash Data File -->
    <?php
    $success_flashData = $this->session->flashdata('success_flashData');
    $error_flashData = $this->session->flashdata('error_flashData');
    $warning_flashData = $this->session->flashdata('warning_flashData');

    if ($success_flashData !== NULL) {
        echo '<div class="alert alert-success" role="alert">'.$success_flashData.'</div>';
    }

    if ($error_flashData !== NULL) {
        echo '<div class="alert alert-danger" role="alert">'.$error_flashData.'</div>';
    }

    if ($warning_flashData !== NULL) {
        echo '<div class="alert alert-danger" role="alert">'.$warning_flashData.'</div>';
    }
?>
    
    <?= form_open() ?>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?= set_value('username'); ?>" class="form-control <?= (form_error('username') == "" ? '':'is-invalid') ?>" placeholder="Enter Userame">  
            <?= form_error('username'); ?>           
        </div>
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="full_name" value="<?= set_value('full_name'); ?>" class="form-control <?= (form_error('full_name') == "" ? '':'is-invalid') ?>" placeholder="Enter Name">
            <?= form_error('full_name'); ?>        
        </div>
        <!-- <div class="form-group">
            <label>Email address</label>
            <input type="email" name="email" value="<?= set_value('email'); ?>" class="form-control <?= (form_error('email') == "" ? '':'is-invalid') ?>" placeholder="Enter Email"> 
            <?= form_error('email'); ?>            
        </div> -->
        <div class="form-group">
            <label>Mobile Number</label>
            <input type="number" name="mobile" value="<?= set_value('mobile'); ?>" class="form-control <?= (form_error('mobile') == "" ? '':'is-invalid') ?>" placeholder="Enter Mobile Number">  
            <?= form_error('mobile'); ?>           
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" value="<?= set_value('password'); ?>" class="form-control <?= (form_error('password') == "" ? '':'is-invalid') ?>" placeholder="Password">
            <?= form_error('password'); ?> 
        </div>
        <!-- <div class="form-group">
            <label>Password Confirmation</label>
            <input type="password" name="passconf" value="<?= set_value('passconf'); ?>" class="form-control <?= (form_error('passconf') == "" ? '':'is-invalid') ?>" placeholder="Password Confirmation">
            <?= form_error('passconf'); ?> 
        </div> -->
        <button type="submit" class="btn btn-primary">Register</button>
    <?= form_close() ?>
</div>
<br>