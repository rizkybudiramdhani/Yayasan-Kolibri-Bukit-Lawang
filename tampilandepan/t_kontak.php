<?php

    include 'koneksi.php';
?>
<div class="contact">
            <div class="container">
                <div class="section-header text-center">
                    <p><?=$language["k"]  ?></p>
                    <h2><?=$language["kk"]  ?></h2>
                </div>
                <div class="contact-img">
                    <img src="img/contact.jpg" alt="Image">
                </div>
                <div class="contact-form">
                        <div id="success"></div>
                        <form method="POST">
                            <div class="control-group">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Your Name" required="required" data-validation-required-message="Please enter your name" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required="required" data-validation-required-message="Please enter your email" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <input type="text" class="form-control" id="subjek" name="subjek" placeholder="Subject" required="required" data-validation-required-message="Please enter a subject" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <textarea class="form-control" id="pesan" name="pesan" placeholder="Message" required="required" data-validation-required-message="Please enter your message"></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                            <div>
                                <input type="submit" value="Send Message" class="btn btn-custom" name="submit" >
                                
                            </div>
                        </form>
                    </div>
            </div>
        </div>
                    <?php
                        if(isset($_POST['submit'])){
                            
                            // print_r($_FILES['gambar']);

                            $nama = addslashes( ucwords($_POST['nama']));
                            $pesan = addslashes(($_POST['pesan']));
                            $email = addslashes(($_POST['email']));
                            $subjek = addslashes(($_POST['subjek']));

                            
                            // $filename = $_FILES['gambar']['name'];
                            // $tmpname = $_FILES['gambar']['tmp_name'];
                            // $filesize = $_FILES['gambar']['size'];

                            // $formatfile = pathinfo($filename, PATHINFO_EXTENSION);
                            // $rename = 'berita' .time().'.'.$formatfile;

                            // $allowedtype =array('png', 'jpg', 'jpeg', 'gif','mp4');

                            // if(!in_array($formatfile, $allowedtype)){
                            //     echo '<div class="alert alert-error"> Format file tidak diizinkan</div>';
                            // }elseif($filesize > 1000000){
                            //     echo '<div class="alert alert-error"> Ukuran file tidak boleh lebih dari 1MB</div>';
                            // }else{

                            //     move_uploaded_file($tmpname,"../img/upload/".$rename );                           

                                    $simpan = mysqli_query($conn, "INSERT INTO pesan VALUES (
                                        null,
                                        '".$nama."',
                                        '".$email."',
                                        '".$subjek."',
                                        '".$pesan."'
                                    )");
                                    if($simpan){
                                        echo '<div class="alert alert-success"> Berhasil Dikirim</div>';
                                    }else{
                                        echo 'Gagal Simpan'.mysqli_error($conn);
                                    }   
                            }

        
                    
                    ?>