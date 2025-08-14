<aside class="main-sidebar" id="alert2">
   <section class="sidebar" id="sibe-box">
      <form class="navbar-form navbar-left search-form2" role="search"  action="#" method="POST">
         <input type='hidden' name='ci_csrf_token' value=''/>            
         <div class="input-group ">
            <input type="text" name="search_text" class="form-control search-form" placeholder="">
            <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" style="padding: 3px 12px !important;border-radius: 0px 30px 30px 0px; background: #fff;" class="btn btn-flat"><i class="fa fa-search"></i></button>
            </span>
         </div>
      </form>
      <ul class="sessionul fixedmenu">
         <li><a href="<?=base_url() ?>dashboard"> <span> <font size="4">DASHBOARD</font></span></a></li>
      </ul>
      <ul class="sidebar-menu verttop">
         <?php if ($_SESSION['status'] == 'a')
{ ?>
         <li class="treeview ">
            <a href="#"><i class="fa fa-object-group"></i> <span>মাঠ কর্মী</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li class=""><a href="<?=base_url() ?>admin/employee_list"><i class="fa fa-angle-double-right"></i>কর্মীর তালিকা</a></li>
              <li class=""><a href="<?=base_url() ?>admin/employee_add"><i class="fa fa-angle-double-right"></i>নতুন কর্মী সংযোজন</a></li>
                <li><a href="#"> <span>&nbsp;</span> </a></li>
            </ul>
         </li>
         <?php
} ?>
         <?php if ($_SESSION['user_id'] == 0)
{ ?>
         <li class="treeview ">
            <a href="#"><i class="fa fa-object-group"></i> <span>প্রশাসকের কাজ</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li class=""><a href="<?=base_url() ?>admin/zone_list"><i class="fa fa-angle-double-right"></i> জোনের তালিকা</a></li>
               <li class=""><a href="<?=base_url() ?>admin/setting"><i class="fa fa-angle-double-right"></i>সঞ্চয় ফেরত তারিখ সংযোজন</a></li>
               <li class=""><a href="<?=base_url() ?>admin/date_add"><i class="fa fa-angle-double-right"></i>পূর্বের মিসিং তারিখ সংযোজন</a></li>
               <li class=""><a href="<?=base_url() ?>admin/date_list"><i class="fa fa-angle-double-right"></i> পূর্বের মিসিং তারিখ</a></li>
              <li class=""><a href="<?=base_url() ?>admin/transfer_member"><i class="fa fa-angle-double-right"></i> সদস্য স্থানান্তর</a></li>
                <li><a href="#"> <span>&nbsp;</span> </a></li>
            </ul>
         </li>
         <?php
} ?>
         <?php if ($_SESSION['status'] == 'u')
{ ?>
         <!--<li class=""><a href="<?=base_url() ?>admin/collection"><i class="fa fa-angle-double-right"></i>দৈনিক কালেকশন</a></li>-->
         <li class=""><a href="<?=base_url() ?>admin/collection_report_user"><i class="fa fa-angle-double-right"></i> কালেকশন রিপোর্ট (সিট) </a></li>
         <li class=""><a href="<?=base_url() ?>admin/pre_collection"><i class="fa fa-angle-double-right"></i>পূর্বের কালেকশন</a><
         <li><a href="#"> <span>&nbsp;</span> </a></li>
         <?php
} ?>
         <?php if ($_SESSION['status'] == 'a')
{ ?>
         <!--  <li class=""><a href="<?=base_url() ?>admin/old_collection"><i class="fa fa-angle-double-right"></i> Previous Collection</a></li>-->
         <?php
} ?>
         <li class="treeview ">
            <a href="#"><i class="fa fa-object-group"></i> <span> সঞ্চয়ী হিসাব</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <?php if ($_SESSION['status'] == 'a')
{ ?>
               <li class=""><a href="<?=base_url() ?>admin/pending_return_list"><i class="fa fa-angle-double-right"></i> সঞ্চয় ফেরত (পেন্ডিং )</a></li>
               <li class=""><a href="<?=base_url() ?>admin/returned_list"><i class="fa fa-angle-double-right"></i> সঞ্চয় ফেরত অ্যাপ্রুভড</a>
               </li>
               <?php
} ?>
               <?php if ($_SESSION['status'] == 'u')
{ ?>
               <li class=""><a href="<?=base_url() ?>admin/account_list"><i class="fa fa-angle-double-right"></i>সঞ্চয়ী সদস্য তালিকা</a></li>
               <li class=""><a href="<?=base_url() ?>admin/account_add"><i class="fa fa-angle-double-right"></i>নতুন সঞ্চয়ী সদস্য</a></li>
               <li><a href="<?=base_url() ?>admin/account_sl"><i class="fa fa-angle-double-right"></i> আপডেট S.L. no</a></li>
                <!--<li class=""><a href="<?=base_url() ?>admin/saving_return"><i class="fa fa-angle-double-right"></i>সঞ্চয় ফেরত(পেন্ডিং)</a></li>-->
               <li class=""><a href="<?=base_url() ?>admin/return_approved"><i class="fa fa-angle-double-right"></i>সঞ্চয় ফেরত আপ্রুভড</a></li>
               <?php
} ?>
               <li><a href="#"> <span>&nbsp;</span> </a></li>
            </ul>
         </li>
         <li class="treeview ">
            <a href="#"><i class="fa fa-object-group"></i> <span> ঋণ হিসাব</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li class=""><a href="<?=base_url() ?>admin/loan_list_ajax"><i class="fa fa-angle-double-right"></i> ঋণী সদস্যর তালিকা</a></li>
                <?php if ($_SESSION['status'] == 'a') { ?>
              <li class=""><a href="<?=base_url() ?>admin/pending_loan_list"><i class="fa fa-angle-double-right"></i> ঋণ (পেন্ডিং )</a></li>
              <li class=""><a href="<?=base_url() ?>admin/approved_loan_list"><i class="fa fa-angle-double-right"></i> ঋণ অ্যাপ্রুভড</a></li>
               <?php } ?>
			<!--<li class=""><a href="<?=base_url() ?>admin/loan_list_ajax"><i class="fa fa-angle-double-right"></i> ঋণী সদস্যর তালিকা</a></li>-->
               <li class=""><a href="<?=base_url() ?>admin/loan_add"><i class="fa fa-angle-double-right"></i> নতুন লোনের একাউন্ট</a></li>
               <!--<li class=""><a href="<?=base_url() ?>admin/loan_add_old"><i class="fa fa-angle-double-right"></i>পুরনো লোন একাউন্ট</a></li>
               --><li><a href="#"> <span>&nbsp;</span> </a></li>
            </ul>
         </li>
         <li class="treeview ">
            <a href="#"><i class="fa fa-object-group"></i> <span>এস এস পি হিসাব</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li class=""><a href="<?=base_url() ?>admin/diposit_list"><i class="fa fa-angle-double-right"></i> এস এস পি সদস্য তালিকা</a></li>
               <li class=""><a href="<?=base_url() ?>admin/diposit_add"><i class="fa fa-angle-double-right"></i> নতুন এস এস পি সদস্য</a></li>
               <?php if ($_SESSION['status'] == 'a')
{ ?>
               <li class=""><a href="<?=base_url() ?>admin/pending_ssp_return_list"><i class="fa fa-angle-double-right"></i> এস এস পি ফেরত (পেন্ডিং )</a></li>
               <li class=""><a href="<?=base_url() ?>admin/ssp_returned_list"><i class="fa fa-angle-double-right"></i> এস এস পি ফেরত অ্যাপ্রুভড</a></li>
                <li class=""><a href="<?=base_url() ?>admin/ssp_report"><i class="fa fa-angle-double-right"></i>এস এস পি রিপোর্ট</a>
               </li>
               <?php
} ?>
               <?php if ($_SESSION['status'] == 'u')
{ ?>
               <li class="">
                  <a href="<?=base_url() ?>admin/emp_total_ssp_report"><i class="fa fa-angle-double-right"></i>এস এস পি রিপোর্ট</a>
               </li>
               <!--<li class=""><a href="<?=base_url() ?>admin/diposit_collection"><i class="fa fa-angle-double-right"></i> এস এস পি গ্রহণ</a></li>-->
               <!--<li class=""><a href="<?=base_url() ?>admin/diposit_return"><i class="fa fa-angle-double-right"></i> এস এস পি ফেরত</a></li>-->
               <?php
} ?>
               <li><a href="#"> <span>&nbsp;</span> </a></li>
            </ul>
         </li>
         <?php if ($_SESSION['status'] == 'a')
{ ?>
         <li class="treeview ">
            <a href="#"><i class="fa fa-object-group"></i> <span>বিনিয়োগ হিসাব</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li class=""><a href="<?=base_url() ?>admin/investment_list"><i class="fa fa-angle-double-right"></i>বিনিয়োগ সদস্য তালিকা</a></li>
               <li class=""><a href="<?=base_url() ?>admin/investment_add"><i class="fa fa-angle-double-right"></i>নতুন বিনিয়োগ একাউন্ট</a></li>
               <li class=""><a href="<?=base_url() ?>admin/investment_collection"><i class="fa fa-angle-double-right"></i> বিনিয়োগ গ্রহণ</a></li>
               <li class=""><a href="<?=base_url() ?>admin/multiple_investment_entry"><i class="fa fa-angle-double-right"></i>মাসিক বিনিয়োগ গ্রহণ</a></li>
               <li class=""><a href="<?=base_url() ?>admin/investment_return"><i class="fa fa-angle-double-right"></i> বিনিয়োগ ফেরত</a></li>
               <li><a href="#"> <span>&nbsp;</span> </a></li>
            </ul>
         </li>
         <?php
} ?>
         <?php if ($_SESSION['status'] == 'a')
{ ?>
         <li class="treeview ">
            <a href="#"><i class="fa fa-object-group"></i> <span> রিপোর্ট</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li class=""><a href="<?=base_url() ?>admin/collection_report_employee"><i class="fa fa-angle-double-right"></i>দৈনিক কালেকশন সিট</a></li>
               <li class=""><a href="<?=base_url() ?>admin/total_collection_report"><i class="fa fa-angle-double-right"></i>কর্মীদের মোট রিপোর্ট (লেজার )</a></li>
               <li class=""><a href="<?=base_url() ?>admin/all_collection_report"><i class="fa fa-angle-double-right"></i>সমন্বয় রিপোর্ট </a></li>
               <li class=""><a href="<?=base_url() ?>admin/emp_total_collection_report"><i class="fa fa-angle-double-right"></i>একক কালেকশন রিপোর্ট</a></li>
               <li class=""><a href="<?=base_url() ?>admin/emp_total_ssp_report"><i class="fa fa-angle-double-right"></i>একক এস এস পি রিপোর্ট</a>
               </li>
               <li><a href="#"> <span>&nbsp;</span> </a></li>
            </ul>
         </li>
         <?php
} ?>
         <?php if ($_SESSION['status'] == 'a')
{ ?>
         <li class="treeview ">
            <a href="#"><i class="fa fa-object-group"></i> <span> অ্যাকাউন্টস</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
               <li class=""><a href="<?=base_url() ?>admin/office_employee"><i class="fa fa-angle-double-right"></i>কর্মকর্তা/কর্মচারী তালিকা</a></li>
               <li class=""><a href="<?=base_url() ?>admin/bs_ledger_add"><i class="fa fa-angle-double-right"></i>উদ্বৃর্ত্তপত্র খাত সংযোজন</a></li>
               <li class=""><a href="<?=base_url() ?>admin/bs_ledger_list"><i class="fa fa-angle-double-right"></i>উদ্বৃর্ত্তপত্র এর খাতের তালিকা</a></li>
               <li class=""><a href="<?=base_url() ?>admin/ledger_add"><i class="fa fa-angle-double-right"></i>লেজার এর খাত সংযোজন</a></li>
               <li class=""><a href="<?=base_url() ?>admin/ledger_list"><i class="fa fa-angle-double-right"></i>লেজার এর খাতের তালিকা</a></li>
               <li class=""><a href="<?=base_url() ?>admin/dr_voucher"><i class="fa fa-angle-double-right"></i>খরচের ভাউচার</a></li>
               <li class=""><a href="<?=base_url() ?>admin/cr_voucher"><i class="fa fa-angle-double-right"></i>ক্রেডিট(জমা)ভাউচার</a></li>
               <li class=""><a href="<?=base_url() ?>admin/cash_book"><i class="fa fa-angle-double-right"></i>ক্যাশ বই</a></li>
               <li class=""><a href="<?=base_url() ?>admin/general_ledger"><i class="fa fa-angle-double-right"></i>লেজার (খাতের) সাধারণ রিপোর্ট</a></li>
               <li class=""><a href="<?=base_url() ?>admin/trial_balance"><i class="fa fa-angle-double-right"></i>প্রাপ্তি / প্রদান রিপোর্ট</a></li>
               <li class=""><a href="<?=base_url() ?>admin/inc_exp"><i class="fa fa-angle-double-right"></i>আয় / ব্যয় ( লাভ ক্ষতি ) রিপোর্ট</a></li>
               <li class=""><a href="<?=base_url() ?>admin/cash_book_report"><i class="fa fa-angle-double-right"></i>ক্যাশ রির্পোট</a></li>
               <li class=""><a href="<?=base_url() ?>admin/balance_sheet"><i class="fa fa-angle-double-right"></i>উদ্ধৃর্ত্তপত্র রিপোর্ট</a></li>
               <li><a href="#"> <span>&nbsp;</span> </a></li>
            </ul>
         </li>
         <?php
} ?>
         <li class=""><a href="<?php echo base_url(); ?>logout"><i class="fa fa-line-chart"></i> লগ আউট</a></li>
        
      </ul>
   </section>
</aside>
