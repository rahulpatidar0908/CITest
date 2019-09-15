<div class="container">

    <!-- Include Flash Data File -->
    <?= form_open() ?>
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?= set_value('username'); ?>" class="form-control <?= (form_error('username') == "" ? '':'is-invalid') ?>" placeholder="Enter Username"> 
            <?= form_error('username'); ?>            
        </div>      
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" value="<?= set_value('password'); ?>" class="form-control <?= (form_error('password') == "" ? '':'is-invalid') ?>" placeholder="Password">
            <?= form_error('password'); ?> 
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input">
            <label class="form-check-label">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    <?= form_close() ?>
</div>