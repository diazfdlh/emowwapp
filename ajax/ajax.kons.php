<?php
    require_once('../config.php');
    $nperlist = 5;
?>

<?php 
function esc($value){
    // bring the global db connect object into function
    global $conn;
    $val = trim($value);
    $val = mysqli_real_escape_string($conn, $value);
    return $val;
}
    
    if(isset($_POST['mode']) && $_POST['mode'] == 'ahliList'){
        //$cp = $_POST['cp'];
        //$rStart = $nperlist * ($cp - 1);
        $q = $_POST['q'];
        $fil = $_POST['fil'];
        if($fil == 'all'){
            $fil = '';
        }else{
            if($fil == 'p'){
                $fil = " AND kat='penyuluh' ";
            }else{
                $fil = " AND kat='inseminator' ";
            }
        }
        if($q){
            $srch = "nama LIKE '%".$q."%'";
        }else{
            $srch = 'avail = 1';
        }
        $sql = mysqli_query($conn,"SELECT * FROM user inner join ahli on user.id_user=ahli.id_user WHERE ".$srch.$fil." order by avail desc");
        $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
        echo '<div class="row">';
        foreach($row as $r){
            $firstTime=strtotime($r['last_seen']);
            $lastTime=strtotime(date("Y-m-d H:i:s",time()));
            $timeDiff=$lastTime-$firstTime;
            $years = abs(floor($timeDiff / 31536000));
            $days = abs(floor(($timeDiff-($years * 31536000))/86400));
            $hours = abs(floor(($timeDiff-($years * 31536000)-($days * 86400))/3600));
            $mins = abs(floor(($timeDiff-($years * 31536000)-($days * 86400)-($hours * 3600))/60));#floor($timeDiff / 60);
            if($mins < 1){
                $col = '#077703';
            }else{
                $col = '#999';
            }
            ?>
                <div class="col-sm-6" style="cursor: pointer;" onclick="viewAhli(<?php echo $r['id_user']?>)">
                    <div class="card-nb p-3 ahli-prof">
                        <div class="dp" style="width:100px; float:left;display:block;border: 2pt solid <?php echo $col;?>">
                            <div>
                                <img src="<?php echo DP_DIR.$r['dp'].'.png'?>" alt="">
                            </div>
                        </div>
                        <div style="float: left;margin-left:20px;padding-left:10px;display:block;">
                            <h5><?php echo $r['nama']?></h5>
                            <span><i class="fas fa-graduation-cap"></i> <?php echo $r['pend_ah']?></span>
                            <?php if($r['avail']==1 && $_SESSION['user']['role']=='peternak'){?>
                                <div class="btn-chat mt-3" onclick="openChat(<?php echo $r['id_user'];?>)">CHAT</div>
                            <?php }else{?>
                                <div class="btn-chat notava">Tidak Tersedia</div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            <?php
        }
        echo '</div>';
        $n = mysqli_num_rows($sql);
        if($n == 0){
            if($q){?>
            <div style="width:100%;text-align:center;"><h4>Tidak ada Ahli yang anda cari</h4></div>
            <?php }else{
            ?>
            <div style="width:100%;text-align:center;"><h4>Tidak ada Ahli Tersedia</h4></div>
        <?php 
            }
        }else{
            /*$sql = mysqli_query($conn,"SELECT * FROM user WHERE status = 0".$srch);
            $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
            $n = mysqli_num_rows($sql);
            $total = ceil($n/$nperlist);
            ?>
                <div id="pgn-wrap">
            <?php
            for($i=1;$i<=$total;$i++){
                ?>
                    <span onclick="goto(<?php echo $i?>,'#useract')" class="card pgnum <?php if($cp == $i){echo 'active';}?>"><?php echo $i;?></span>
                <?php
            }
            ?>
                </div>
            <?php*/
        }
        
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'vA'){
        $id = $_POST['id'];
        $sql = mysqli_query($conn,"SELECT * FROM chat inner join user on user.id_user=chat.id_u2 WHERE user.id_user = '$id' and rating is NOT null");
        $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
        $n = mysqli_num_rows($sql);
        if($n == 0){
            $rat = 'N/A';
        }
        else{
            $rat = '0';
            foreach($row as $r){
                $rat += $r['rating'];
            }
            $rat = $rat/$n;
        }
        $sql = mysqli_query($conn,"SELECT * FROM user inner join ahli on user.id_user=ahli.id_user WHERE ahli.id_user = '$id'");
        $row = mysqli_fetch_assoc($sql);
        $firstTime=strtotime($row['last_seen']);
        $lastTime=strtotime(date("Y-m-d H:i:s",time()));
        $timeDiff=$lastTime-$firstTime;
        $years = abs(floor($timeDiff / 31536000));
        $days = abs(floor(($timeDiff-($years * 31536000))/86400));
        $hours = abs(floor(($timeDiff-($years * 31536000)-($days * 86400))/3600));
        $mins = abs(floor(($timeDiff-($years * 31536000)-($days * 86400)-($hours * 3600))/60));#floor($timeDiff / 60);
        if($mins < 1){
            $col = '#077703';
        }else{
            $col = '#999';
        }
        //echo "<p>Time Passed: " . $years . " Years, " . $days . " Days, " . $hours . " Hours, " . $mins . " Minutes.</p>";
        if($row['thn_mulai']==null){
            $thn = 'N/A';
        }else{
            $thn = date("Y",time()) - substr($row['thn_mulai'], 0, 4);
        }
        ?>
            <div class="card-nb p-5" style="width: 500px;margin:0 auto;">
                <div class="row">
                    <div class="col-1">
                        <div class="chat-btn" onclick="backProf()">
                            <i class="fas fa-arrow-left"></i>
                        </div>
                    </div>
                </div>
                <div class="dp" style="width:150px;margin:0 auto;border: 2pt solid <?php echo $col;?>">
                    <div>
                        <img src="<?php echo DP_DIR.$row['dp'].'.png'?>" alt="">
                    </div>
                </div>
                <h2 style="text-align: center;"><?php echo $row['nama'];?></h2>
                <h6 style="text-align: center;text-transform:capitalize;"><?php echo $row['kat'];?></h6>
                <div id="prof-rat"><i class="fas fa-star mr-2" style="color:gold"></i><?php echo $rat;?> <div class="rat-det">| Dari <?php echo $n;?> Sesi Chat</div></div>
                <div class="row" style="max-width:400px;margin:10px auto;">
                    <div class="col-1" style="text-align: center;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="col-11">
                        <h5>Lulusan Dari</h5>
                        <?php if($row['pend_ah']){
                            echo $row['pend_ah'];
                        }else{
                            echo 'N/A';
                        }
                        
                        ?>
                    </div>
                </div>
                <div class="row" style="max-width:400px;margin:10px auto;">
                    <div class="col-1" style="text-align: center;">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="col-11">
                        <h5>Pengalaman</h5>
                        <?php echo $thn;?> Tahun
                    </div>
                </div>
                <?php if($row['avail']==1 && $_SESSION['user']['role']=='peternak'){?>
                    <div class="btn-chat2" style="width:100%;font-size:15pt;font-weight:700" onclick="openChat(<?php echo $row['id_user'];?>)">CHAT</div>
                <?php }else{?>
                    <div class="btn-chat notava" style="width:100%;font-size:15pt;font-weight:700">Tidak Tersedia</div>
                <?php }?>
            </div>
        <?php
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'chatList'){
        if(isset($_SESSION['user']) && $_SESSION['user']['role']=='peternak'){
            $id = $_SESSION['user']['id_user'];
            $sql = mysqli_query($conn,"SELECT * FROM user inner join chat on user.id_user=chat.id_u2 WHERE id_u1 = '$id' and chat.status = 1 order by chat.created desc");
            $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
            $n = mysqli_num_rows($sql);
            echo '<div class="card-nb p-3">';
            foreach($row as $r){
                $id_chat = $r['id_chat'];
                $sql1 = mysqli_query($conn,"SELECT * from isichat where id_chat='$id_chat' and who = 'u2' and seen = 0");
                $n = mysqli_num_rows($sql1);
                ?>
                <div onclick="viewChat(<?php echo $r['id_chat'];?>,1)" class="p-2 mb-2 row chat-bubble" style="margin:0;align-items:center;position:relative">
                    <?php if($n){echo '<div class="new-msg">'.$n.'</div>';}?>
                    <div class="col-3">
                        <div class="dp" style="width:50px;height:50px">
                            <div>
                                <img src="<?php echo DP_DIR.$r['dp'].'.png'?>" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-9" style="padding-left: 0;">
                        <h5><?php echo $r['nama'];?></h5>
                    </div>
                </div>
                <?php
            }
            $sql = mysqli_query($conn,"SELECT * FROM user inner join chat on user.id_user=chat.id_u2 WHERE id_u1 = '$id' and chat.status = 0 order by rating");
            $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
            ?>
            <div style="position: relative;text-align:center;padding:10px;">
                <h5 style="color:#dcdcdc;">Riwayat Chat</h5>
                <div style="position: absolute;top:20px;right:0;left:0;height:2pt;background:linear-gradient(90deg, rgba(220,220,220,1) 0%, rgba(220,220,220,1) 23%, rgba(255,255,255,0) 24%, rgba(255,255,255,0) 75%, rgba(220,220,220,1) 76%, rgba(220,220,220,1) 100%);"></div>
            </div>
            <?php
            foreach($row as $r){
                $id_chat = $r['id_chat'];
                $sql1 = mysqli_query($conn,"SELECT * from isichat where id_chat='$id_chat' and who = 'u2' and seen = 0");
                $n = mysqli_num_rows($sql1);
                ?>
                <div onclick="viewChat(<?php echo $r['id_chat'];?>,0)" class="p-2 mb-2 row chat-bubble" style="margin:0;align-items:center;position:relative">
                    <?php if($n){echo '<div class="new-msg">'.$n.'</div>';}?>
                    <div class="col-3">
                        <div class="dp" style="width:50px;height:50px">
                            <div>
                                <img src="<?php echo DP_DIR.$r['dp'].'.png'?>" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-6" style="padding-left: 0;">
                        <h5><?php echo $r['nama'];?></h5>
                    </div>
                    <div class="col-3">
                        <?php if($r['rating']){?>
                            <i class="fas fa-star" style="color:gold"></i><?php echo $r['rating']?>
                        <?php }else{?>
                            <i style="font-size: 6pt;color:#999">Belum DiRating</i>
                        <?php }?>
                    </div>
                </div>
                <?php
            }
            $n2 = mysqli_num_rows($sql);
            if($n == 0 && $n2 == 0){
                echo '<h6 style="text-align: center;margin:10px 0;color:#999;">Tidak ada Riwayat Chat</h6>';
            }
            echo '</div>';
        }elseif(isset($_SESSION['user'])){
            ?>
                <div class="card-nb p-3">
                    <h4 style="text-align: center;padding-bottom:10px;border-bottom:1pt solid #dcdcdc;">Fitur ini hanya untuk peternak</h4>
                    <h6 style="text-align: center;">Ganti Akun ?<a href="<?php echo BASE_URL?>logout.php">Logout</a> untuk dapat berganti akun</h6>
                </div>
            <?php
        }else{
            ?>
                <div class="card-nb p-3">
                    <h4 style="text-align: center;padding-bottom:10px;border-bottom:1pt solid #dcdcdc;">Fitur ini hanya untuk peternak</h4>
                    <h6 style="text-align: center;"><a href="<?php echo BASE_URL?>login.php">Login</a> atau <a href="<?php echo BASE_URL?>signup.php">Daftar</a> untuk dapat mengakses</h6>
                </div>
            <?php
        }
        
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'oc'){
        $id2 = $_POST['id'];
        $id1 = $_SESSION['user']['id_user'];
        $sql = mysqli_query($conn,"SELECT * from ahli where id_user = '$id2' and avail = 1");
        if(mysqli_num_rows($sql)){
            $sql = mysqli_query($conn,"SELECT * from chat where id_u1 = '$id1' and id_u2 = '$id2' and status = 1");
            if(mysqli_num_rows($sql)!=0){
                $sql = mysqli_query($conn,"SELECT id_chat from chat where id_u1 = '$id1' and id_u2 = '$id2' and status = 1");
                $chatinfo = mysqli_fetch_assoc($sql);
                $id_chat = $chatinfo['id_chat'];
                echo $id_chat;
                
            }else{
                $sql = mysqli_query($conn,"INSERT INTO chat (id_u1,id_u2,created,status) VALUES('$id1','$id2',now(),1);");
                $sql = mysqli_query($conn,"UPDATE ahli set avail = 0 where id_user = '$id2'");
                $sql = mysqli_query($conn,"SELECT id_chat from chat where id_u1 = '$id1' and id_u2 = '$id2' and status = 1");
                $chatinfo = mysqli_fetch_assoc($sql);
                $id_chat = $chatinfo['id_chat'];
                echo $id_chat;
            }
        }else{
            echo 0;
        }
        
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'ocr'){
        $id_chat = $_POST['id'];
        $id1 = $_SESSION['user']['id_user'];
        $sql = mysqli_query($conn,"SELECT * from chat where id_chat ='$id_chat'");
        $chatinfo = mysqli_fetch_assoc($sql);
        if(mysqli_num_rows($sql)!=0){
            $id2 = $chatinfo['id_u2'];
            $sql = mysqli_query($conn,"SELECT * from user where id_user = '$id2'");
            $user = mysqli_fetch_assoc($sql);
            if($chatinfo['status'] == 1){
                ?>
                <div class="card card-nb">
                    <div class="chat-wrap">
                        <div class="chat-header row" style="margin:0;display:flex;align-items:center;justify-content: center;">
                            <div class="col-2">
                                <div class="chat-btn" onclick="backlistChat()">
                                    <i class="fas fa-arrow-left"></i>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="dp" style="width:50px">
                                    <div>
                                        <img src="<?php echo DP_DIR.$user['dp'].'.png'?>" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <h4><?php echo $user['nama'];?></h4>
                            </div>
                        </div>
                        <div class="chat-body">
                            <?php
                                $sql = mysqli_query($conn,"SELECT * FROM isichat where id_chat='$id_chat' order by created");
                                $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
                                foreach($row as $r){
                                    $time = date('h.i',strtotime($r['created']));
                                    ?>
                                    <div class="<?php if($r['who']=='u1'){echo'chat-sent';}else{echo 'chat-rec';}?>">
                                        <div><?php echo $r['isi'];?></div>
                                        <span class="isi-detail <?php if($r['who']=='u1' && $r['seen']){echo 'seen';}?>"> <?php if($r['who']=='u1' && $r['seen']){echo 'seen';}?> <?php echo $time;?></span>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="chat-control">
                            <div class="row" style="margin:0;height:100%;display:flex;align-items:center;justify-content: center;">
                                <div class="col-2" style="text-align: center;padding:0">
                                    <form enctype="multipart/form-data"><input type="file" id="img-file" style="display: none;" accept="image/*"></form>
                                    <input type="text" id="id-ch" value="<?php echo $chatinfo['id_chat'];?>" hidden>
                                    <label for="img-file">
                                        <div id="btn-img" class="chat-btn">
                                            <i class="fas fa-image "></i>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-8" style="height: 100%;padding:0;overflow-y:scroll;">
                                    <div id="msg-content" contenteditable="true"></div>
                                </div>
                                <div class="col-2" style="text-align: center;padding:0">
                                    <div id="btn-send" class="chat-btn" onclick="send(<?php echo $chatinfo['id_chat'];?>)"> 
                                        <i class="fas fa-paper-plane "></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <script>
                    $('#img-file').change(function(){
                        var name = $('#img-file')[0].files[0].name;
                        var id = $('#id-ch').val();
                        var fd = new FormData();
                        var ext = name.split('.').pop().toLowerCase();
                        if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                            alert("Invalid Image File");
                        }else{
                            var oFReader = new FileReader();
                            oFReader.readAsDataURL($('#img-file')[0].files[0]);
                            var f = $('#img-file')[0].files[0];
                            var fsize = f.size||f.fileSize;
                            if(fsize > 10000000){
                                alert("Ukuran File Terlalu Besar");
                            }
                            else
                            {
                                fd.append("img", $('#img-file')[0].files[0]);
                                fd.append("mode", 'sendImg');
                                fd.append("id", id);
                                $('.kiri-load').css('display','block');
                                $.ajax({
                                    url:"<?php echo BASE_URL?>/ajax/ajax.kons.php",
                                    method:"POST",
                                    data:fd,
                                    processData: false,
                                    contentType: false,
                                    success:function(data)
                                    {
                                        $('.kiri-load').css('display','none');
                                        $('.chat-body').append(data);
                                        $('.chat-body').stop().animate({ scrollTop: $('.chat-body')[0].scrollHeight}, 1000);
                                    },error:function(data){
                                        console.log('ERROR NIH');
                                    }
                                });
                            }
                        }
                        
                    })
                    document.querySelector("div[contenteditable]").addEventListener("paste", function(e) {
                        e.preventDefault();
                        var text = e.clipboardData.getData("text/plain");
                        document.execCommand("insertHTML", false, text);
                    });
                </script>
                <?php
                $sql = mysqli_query($conn,"UPDATE isichat set seen=1 where id_chat='$id_chat' and who = 'u2'");
            }else{
                ?>
                <div class="card card-nb">
                    <div class="chat-wrap">
                        <div class="chat-header row" style="margin:0;display:flex;align-items:center;justify-content: center;">
                            <div class="col-2">
                                <div class="chat-btn"  onclick="backlistChat()">
                                    <i class="fas fa-arrow-left"></i>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="dp" style="width:50px;">
                                    <div>
                                        <img src="<?php echo DP_DIR.$user['dp'].'.png'?>" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <h4><?php echo $user['nama'];?></h4>
                            </div>
                        </div>
                        <div class="chat-body">
                            <?php
                                $sql = mysqli_query($conn,"SELECT * FROM isichat where id_chat='$id_chat' order by created");
                                $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
                                foreach($row as $r){
                                    $time = date('h.i',strtotime($r['created']));
                                    ?>
                                    <div class="<?php if($r['who']=='u1'){echo'chat-sent';}else{echo 'chat-rec';}?>">
                                        <div><?php echo $r['isi'];?></div>
                                        <span class="isi-detail <?php if($r['who']=='u1' && $r['seen']){echo 'seen';}?>"> <?php if($r['who']=='u1' && $r['seen']){echo 'seen';}?> <?php echo $time;?></span>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="chat-control" style="height: auto;">
                            <p style="margin-top:10px;margin-bottom:0;margin-bottom:0;text-align: center;font-size:8pt;">Sesi Chat Sudah Selesai</p>
                            <?php if($chatinfo['rating']){?>
                                <div style="text-align: center;">
                                    <?php for($i=1;$i<=5;$i++){
                                        if($i<=$chatinfo['rating']){
                                            echo '<i class="fas fa-star" style="color:gold"></i>';
                                        }else{
                                            echo '<i class="fas fa-star"></i>';
                                        }
                                    }?>
                                </div>
                            <?php }else{?>
                                <div class="star-rating">
                                    <input id="star-5" type="radio" name="rating" value="5" />
                                    <label for="star-5" title="5 stars">
                                        <i class="active fa fa-star" aria-hidden="true"></i>
                                    </label>
                                    <input id="star-4" type="radio" name="rating" value="4" />
                                    <label for="star-4" title="4 stars">
                                        <i class="active fa fa-star" aria-hidden="true"></i>
                                    </label>
                                    <input id="star-3" type="radio" name="rating" value="3" />
                                    <label for="star-3" title="3 stars">
                                        <i class="active fa fa-star" aria-hidden="true"></i>
                                    </label>
                                    <input id="star-2" type="radio" name="rating" value="2" />
                                    <label for="star-2" title="2 stars">
                                        <i class="active fa fa-star" aria-hidden="true"></i>
                                    </label>
                                    <input id="star-1" type="radio" name="rating" value="1" />
                                    <label for="star-1" title="1 star">
                                        <i class="active fa fa-star" aria-hidden="true"></i>
                                    </label>
                                    
                                </div>
                                <div style="width: 100%;text-align:center"><button class="btn-chat" style="margin:0 auto;border:none;" onclick="subStar(<?php echo $id_chat;?>)">Submit!</button></div>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <script>
                    function subStar(id){
                        star = $("input[name='rating']:checked").val();
                        if(star){
                            var mode = "subStar";
                            $('.kiri-load').css('display','block');
                            $.ajax({
                                url:"<?php echo BASE_URL?>/ajax/ajax.kons.php",
                                method:"POST",
                                data:{mode:mode,star:star,id:id},
                                success:function(data)
                                {
                                    $('.kiri-load').css('display','none');
                                    viewChat(id)
                                }
                            });
                        }
                    }
                </script>
                <?php
            }
        }
    }
?>

<?php 
    if(isset($_POST['mode']) && $_POST['mode'] == 'cek'){
        $id = $_SESSION['user']['id_user'];
        //$lastChatId = $_POST['lcid'];
        $openedChatid = $_POST['opch'];

        $sql = mysqli_query($conn,"SELECT * from isichat where who = 'u2' and seen = 0");
        $n = mysqli_num_rows($sql);
        if(mysqli_num_rows($sql)){
            $nm = 1; 
        }else{
            $nm = 0;
        }
        $sql = mysqli_query($conn,"SELECT * from chat inner join isichat on chat.id_chat=isichat.id_chat where chat.id_chat ='$openedChatid' and who = 'u2' and seen = 0");
        $n = mysqli_num_rows($sql);
        if(mysqli_num_rows($sql)){
            $nmc = 1; 
        }else{
            $nmc = 0;
        }
        $myObj = new \stdClass();
        $myObj->nm = $nm;
        $myObj->nmc = $nmc;

        $myJSON = json_encode($myObj);

        echo $myJSON;
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'send'){
        $id_chat = $_POST['id'];
        $isi = $_POST['isi'];
        $created = date('h.i',time());
        $sql = mysqli_query($conn,"INSERT INTO isichat (id_chat,who,isi,seen,created) VALUES('$id_chat','u1','$isi',0,now())");
        ?>
            <div class="chat-sent">
                <div><?php echo $isi;?></div>
                <span class="isi-detail"><?php echo $created;?></span>
            </div>
        <?php 
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'rec'){
        $id_chat = $_POST['id'];
        $sql = mysqli_query($conn,"SELECT * FROM isichat where id_chat ='$id_chat' and who='u2' and seen = '0'");
        $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
        ?>

        <?php
        foreach($row as $r){
            
        $created = date('h.i',strtotime($r['created']));
        ?>
        <div class="chat-rec">
            <div><?php echo $r['isi'];?></div>
            <span class="isi-detail"><?php echo $created;?></span>
        </div>
        <?php
        }
        $sql = mysqli_query($conn,"UPDATE isichat set seen=1 where id_chat='$id_chat' and who = 'u2'");
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'sendImg'){
        $id_chat = $_POST['id'];
        $img = explode('.', $_FILES["img"]["name"]);
        $ext = end($img);
        $imgname = $id_chat.'_'.date('Ymdhi',time()).'.'.$ext;
        $location = ROOT_PATH.'/ass/img/chat/'.$imgname;
        move_uploaded_file($_FILES["img"]["tmp_name"], $location);
        $img = '<img src="'.CHATIMG_DIR.$imgname.'" onclick="showImg(this)" style="width:100%;cursor:pointer;">';
        $created = date('h.i',time());
        $sql = mysqli_query($conn,"INSERT INTO isichat (id_chat,who,isi,seen,created) VALUES('$id_chat','u1','$img',0,now())");
        ?>
        <div class="chat-sent">
            <div><?php echo $img;?></div>
            <span class="isi-detail"><?php echo $created;?></span>
        </div>
        <?php 
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'cek2'){
        $id_chat = $_POST['id'];
        $sql = mysqli_query($conn,"SELECT * from chat where id_chat = '$id_chat' and status = 1");
        if(mysqli_num_rows($sql)==0){
            echo 2;
        }
        $sql = mysqli_query($conn,"SELECT * from isichat where id_chat = '$id_chat' and who='u1' and seen = 0");
        if(mysqli_num_rows($sql)==0){
            echo 1;
        }
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'subStar'){
        $star = $_POST['star'];
        $id_chat = $_POST['id'];
        $sql = mysqli_query($conn,"UPDATE chat set rating='$star' where id_chat='$id_chat'");
    }

?>


