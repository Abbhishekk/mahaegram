<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <img src="img/logo.png">
        </div>
        <div class="sidebar-brand-text mx-3">
            <!-- <img accesskey="" src="img/logo.png" alt="logo" style="width: 100px; height: 50px;"> -->
            माहईग्राम
        </div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading p-1" style="background-color: #a6b9ef;">
        <span class="h6" style="color:white;">दैनंदिन कामकाज</span>
    </div>
    <li class="nav-item">
        <a class="nav-link <?php if ($page == "namuna8") echo ""; else echo "collapsed"; ?>" href="#"
            data-toggle="collapse" data-target="#collapseBootstrap" aria-expanded="true"
            aria-controls="collapseBootstrap">
            <i class="far fa-fw fa-window-maximize"></i>
            <span>नामुना क्रमांक 8</span>
        </a>
        <div id="collapseBootstrap" class="collapse <?php if ($page == "namuna8") echo "show"; ?> "
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <ul class="navbar-nav accordion" id="accordionSidebar8">
                <li class="nav-item">
                    <a class="nav-link <?php if ($subpage != 'ahaval') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapAhaval" aria-expanded="true"
                        aria-controls="collapseBootstrapAhaval">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>अहवाल</span>
                    </a>
                    <div id="collapseBootstrapAhaval"
                        class="collapse <?php if ($subpage == 'ahaval') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="alerts.html">असेसमेंट रजिस्टर</a>
                            <a class="collapse-item" href="buttons.html">नमुना क्र ८ मालमत्ता माहिती अहवाल</a>
                            <a class="collapse-item" href="dropdowns.html">असेसमेंट रजिस्टर (वैयक्तिक)</a>
                            <a class="collapse-item" href="modals.html">असेसमेंट रजिस्टर फेरफार नुसार अहवाल</a>

                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($subpage != 'yearlyWork') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapYearlyWork" aria-expanded="true"
                        aria-controls="collapseBootstrapYearlyWork">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>वार्षिक कामकाज</span>
                    </a>
                    <div id="collapseBootstrapYearlyWork"
                        class="collapse <?php if ($subpage == 'varshik_kamkaj') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item"
                                href="namuna8_varshikkamkaj_assesment_ragister_ghoshwara.php">असेसमेंट रजिस्टर गोषवारा
                                प्रमाणीकर</a>
                            <a class="collapse-item" href="namuna8_varshikkamkaj_malmatta_index_change.php">मालमत्ता
                                अ.क्र. बदला</a>
                            <a class="collapse-item" href="namuna8_varshikkamkaj_malmatta_badal.php">मालमत्ता बदल</a>
                            <a class="collapse-item" href="namuna8_varshikkamkaj_namuna_8-9_madhi_pherphar.php">नमुना
                                ८-९ मधील मिळकती मधील फरफार</a>
                            <a class="collapse-item"
                                href="namuna8_varshikkamkaj_namuna_8_assesment_ragister_auto.php">नमुना क्र. ८ असेसमेंट
                                रजिस्टर (Auto)</a>
                            <a class="collapse-item" href="namuna8_varshikkamkaj_boja_nond.php">बोजा नोंद / कमी करणे</a>
                            <a class="collapse-item" href="namuna8_varshikkamkaj_milkat_kar_aakarni.php">मिळकत कर
                                आकारणी</a>

                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($subpage != 'malmatta') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapMalmatta" aria-expanded="true"
                        aria-controls="collapseBootstrapMalmatta">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>मालमत्ता माहिती</span>
                    </a>
                    <div id="collapseBootstrapMalmatta"
                        class="collapse <?php if ($subpage == 'malmatta') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="Form_Name_masters.php">नवीन नाव नोंदणी</a>
                            <!-- <a class="collapse-item" href="Malmatta.php">मालमत्ता माहिती</a> -->
                            <a class="collapse-item" href="Form_Malmatta_N8.php">नमुना क्रमांक ८ (मालमत्ता माहिती)</a>
                            <a class="collapse-item" href="ApproveProperty.php">मालमत्ता माहिती प्रमाणिकरण</a>
                            <a class="collapse-item" href="namuna8_malmatta_malmatta_pherphar_arja.php">मालमत्ता फेरफार
                                अर्ज</a>
                            <a class="collapse-item" href="namuna8_malmatta_malmatta_pherphar.php">मालमत्ता फेरफार</a>

                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link  <?php if ($subpage != 'wardMaster') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapMaster" aria-expanded="true"
                        aria-controls="collapseBootstrapMaster">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>मास्टर्स</span>
                    </a>
                    <div id="collapseBootstrapMaster"
                        class="collapse <?php if ($subpage == 'wardMaster') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="./wardMaster.php">वार्ड माहिती</a>

                            <a class="collapse-item" href="./roadMaster.php">रस्ते माहिती</a>
                            <a class="collapse-item" href="./durationMaster.php">कालावधी माहिती</a>
                            <a class="collapse-item" href="./HealthAndLightTax.php">आरोग्य व दिवाबत्ती कर माहिती</a>
                            <a class="collapse-item" href="./valmitkar_darMaster.php">मिळकत कर दर माहिती</a>
                            <a class="collapse-item" href="./waterTaxRateInfo.php">पाणीपट्टी कर</a>
                            <a class="collapse-item" href="./rediRecnorInfo.php">रेडीरेकनर दर माहिती</a>

                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if ($page == "namuna10") echo ""; else echo "collapsed"; ?>" href="#"
            data-toggle="collapse" data-target="#collapseNamuna10" aria-expanded="true"
            aria-controls="collapseNamuna10">
            <i class="far fa-fw fa-window-maximize"></i>
            <span>नामुना क्रमांक 10</span>
        </a>
        <div id="collapseNamuna10" class="collapse <?php if ($page == "namuna10") echo "show"; ?> "
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <ul class="navbar-nav accordion" id="accordionSidebar10">
                <li class="nav-item">
                    <a class="nav-link <?php if ($subpage != 'ahaval') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapNamuna10Ahaval" aria-expanded="true"
                        aria-controls="collapseBootstrapNamuna10Ahaval">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>अहवाल</span>
                    </a>
                    <div id="collapseBootstrapNamuna10Ahaval"
                        class="collapse <?php if ($subpage == 'ahaval') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar10">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="namuna10_ahaval_kar_va_fi.php">कर व फी पावती अहवाल</a>

                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($subpage != 'dainandin') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapNamuna10dainandin" aria-expanded="true"
                        aria-controls="collapseBootstrapNamuna10dainandin">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>दैनंदिन कामकाज</span>
                    </a>
                    <div id="collapseBootstrapNamuna10dainandin"
                        class="collapse <?php if ($subpage == 'malmatta') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar10">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="namuna10_dainandin_bank_bharne.php">बँक भरणा</a>
                            <!-- <a class="collapse-item" href="Malmatta.php">मालमत्ता माहिती</a> -->
                            <a class="collapse-item" href="namuna10_dainandin_khate_to_khate_transfar.php">खाते टू खाते ट्रान्सफर</a>
                            <a class="collapse-item" href="namuna10_dainandin_jama_pavati_radd.php">जमा पावती रद्द करणे</a>
                            <a class="collapse-item" href="namuna10_dainandin_jama_pavati_kade.php">जमा पावती काढणे</a>
                            <a class="collapse-item" href="namuna10_dainandin_ghar_patti_kar_vasuli.php">घरफाळा / घरपट्टी कर वसुली</a>
                            <a class="collapse-item" href="namuna10_dainandin_chekchi_sathi.php">आलेल्या चेकची स्थिती</a>

                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($subpage != 'yearlyWork') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapNamuna10YearlyWork" aria-expanded="true"
                        aria-controls="collapseBootstrapNamuna10YearlyWork">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>वार्षिक कामकाज</span>
                    </a>
                    <div id="collapseBootstrapNamuna10YearlyWork"
                        class="collapse <?php if ($subpage == 'varshik_kamkaj') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar10">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item"
                                href="namuna10_varshikkamkaj_shillak.php">वर्षाच्या सुरवातीची शिल्लक</a>
                            <a class="collapse-item" href="namuna10_varshikkamkaj_vasuli_khate.php">वसूल खाते ठरवणे</a>
                            <a class="collapse-item" href="namuna10_varshikkamkaj_pavati_pustak_nond.php">पावती पुस्तक नोंदणी /वितरण</a>
            

                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link  <?php if ($subpage != 'master') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapNamuna10Master" aria-expanded="true"
                        aria-controls="collapseBootstrapNamuna10Master">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>मास्टर्स</span>
                    </a>
                    <div id="collapseBootstrapNamuna10Master"
                        class="collapse <?php if ($subpage == 'master') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar10">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="namuna10_master_bank.php">बँकांची माहिती</a>

                            <a class="collapse-item" href="namuna10_master_chekbuk.php">धनादेश (चेकबुक) माहिती</a>
                            <a class="collapse-item" href="namuna10_master_vastu.php">वस्तूंची माहिती</a>
                           

                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading p-1" style="background-color: #a6b9ef;">
        <span class="h6" style="color:white;">डेटा एंट्री कामकाज</span>
    </div>
    <li class="nav-item">
        <a class="nav-link <?php //if ($page == "namuna8") echo ""; else echo "collapsed"; ?>" href="#"
            data-toggle="collapse" data-target="#onetothirtythree" aria-expanded="true"
            aria-controls="onetothirtythree">
            <i class="far fa-fw fa-window-maximize"></i>
            <span>१ ते ३३ नमूने </span>
        </a>
        <div id="onetothirtythree" class="collapse <?php //if ($page == "namuna8") echo "show"; ?> "
            aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
            <ul class="navbar-nav accordion" id="accordionSidebar8">
                <li class="nav-item">
                    <a class="nav-link ml-2 <?php //if ($subpage != 'ahaval') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapnamuna2" aria-expanded="true"
                        aria-controls="collapseBootstrapnamuna2">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>नमुना क्रमांक २</span>
                    </a>
                    <div id="collapseBootstrapnamuna2"
                        class="collapse <?php //if ($subpage == 'ahaval') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <ul class="navbar-nav accordion" id="accordionSidebar8">

                                <li class="nav-item ml-3">
                                    <a class="nav-link <?php if ($subpage != 'yearlyWork') { echo 'collapsed'; } ?>"
                                        href="#" data-toggle="collapse" data-target="#collapseBootstrapnamuna2_ahaval"
                                        aria-expanded="true" aria-controls="collapseBootstrapnamuna2_ahaval">
                                        <i class="far fa-fw fa-window-maximize"></i>
                                        <span>अहवाल</span>
                                    </a>
                                    <div id="collapseBootstrapnamuna2_ahaval"
                                        class="collapse <?php if ($subpage == 'yearlyWork') { echo 'show'; } ?>"
                                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <a class="collapse-item" href="namuna2_ahaval_puravniandajpatrak.php">पुरवणी
                                                अंदाजपत्रक </a>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item ml-3">
                                    <a class="nav-link <?php if ($subpage != 'yearlyWork') { echo 'collapsed'; } ?>"
                                        href="#" data-toggle="collapse"
                                        data-target="#collapseBootstrapnamuna2_varshikkamkaj" aria-expanded="true"
                                        aria-controls="collapseBootstrapnamuna2_varshikkamkaj">
                                        <i class="far fa-fw fa-window-maximize"></i>
                                        <span>वार्षिक कामकाज</span>
                                    </a>
                                    <div id="collapseBootstrapnamuna2_varshikkamkaj"
                                        class="collapse <?php if ($subpage == 'yearlyWork') { echo 'show'; } ?>"
                                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <a class="collapse-item"
                                                href="namuna2_varshikkamkaj_punarviniyojanandajpatrak.php">पुनर्विनियोजन
                                                अंदाजपत्रक</a>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>

                    </div>

                </li>
                <li class="nav-item">
                    <a class="nav-link ml-2 <?php //if ($subpage != 'ahaval') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapnamuna3" aria-expanded="true"
                        aria-controls="collapseBootstrapnamuna3">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>नमुना क्रमांक ३</span>
                    </a>
                    <div id="collapseBootstrapnamuna3"
                        class="collapse <?php //if ($subpage == 'ahaval') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <ul class="navbar-nav accordion" id="accordionSidebar8">

                                <li class="nav-item ml-3">
                                    <a class="nav-link <?php if ($subpage != 'yearlyWork') { echo 'collapsed'; } ?>"
                                        href="#" data-toggle="collapse" data-target="#collapseBootstrapnamuna3_ahaval"
                                        aria-expanded="true" aria-controls="collapseBootstrapnamuna3_ahaval">
                                        <i class="far fa-fw fa-window-maximize"></i>
                                        <span>अहवाल</span>
                                    </a>
                                    <div id="collapseBootstrapnamuna3_ahaval"
                                        class="collapse <?php if ($subpage == 'yearlyWork') { echo 'show'; } ?>"
                                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <a class="collapse-item"
                                                href="namuna3_ahaval_varshikjamakharcha.php">वार्षिक जमा खर्च </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>

                </li>

                <li class="nav-item">
                    <a class="nav-link ml-2  <?php //if ($subpage != 'ahaval') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapnamuna4" aria-expanded="true"
                        aria-controls="collapseBootstrapnamuna4">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>नमुना क्रमांक ४</span>
                    </a>
                    <div id="collapseBootstrapnamuna4"
                        class="collapse <?php //if ($subpage == 'ahaval') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <ul class="navbar-nav accordion" id="accordionSidebar8">

                                <li class="nav-item ml-3">
                                    <a class="nav-link <?php if ($subpage != 'yearlyWork') { echo 'collapsed'; } ?>"
                                        href="#" data-toggle="collapse" data-target="#collapseBootstrapnamuna4_ahaval"
                                        aria-expanded="true" aria-controls="collapseBootstrapnamuna4_ahaval">
                                        <i class="far fa-fw fa-window-maximize"></i>
                                        <span>अहवाल</span>
                                    </a>
                                    <div id="collapseBootstrapnamuna4_ahaval"
                                        class="collapse <?php if ($subpage == 'yearlyWork') { echo 'show'; } ?>"
                                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <a class="collapse-item"
                                                href="namuna4_ahaval_panchayatichimatta.php">पंचायतीची
                                                मत्ता व दायित्वे </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>

                </li>
                <li class="nav-item">
                    <a class="nav-link ml-2 <?php //if ($subpage != 'ahaval') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapnamuna5" aria-expanded="true"
                        aria-controls="collapseBootstrapnamuna5">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>नमुना क्रमांक ५ </span>
                    </a>
                    <div id="collapseBootstrapnamuna5"
                        class="collapse <?php //if ($subpage == 'ahaval') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <ul class="navbar-nav accordion" id="accordionSidebar8">

                                <li class="nav-item ml-3">
                                    <a class="nav-link <?php if ($subpage != 'yearlyWork') { echo 'collapsed'; } ?>"
                                        href="#" data-toggle="collapse" data-target="#collapseBootstrapnamuna5_ahaval"
                                        aria-expanded="true" aria-controls="collapseBootstrapnamuna5_ahaval">
                                        <i class="far fa-fw fa-window-maximize"></i>
                                        <span>अहवाल</span>
                                    </a>
                                    <div id="collapseBootstrapnamuna5_ahaval"
                                        class="collapse <?php if ($subpage == 'yearlyWork') { echo 'show'; } ?>"
                                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <a class="collapse-item"
                                                href="namuna5_ahaval_samanyarokadvahi_dainandin.php">सामान्य रोकड
                                                वही(दैनंदिन) </a>
                                            <a class="collapse-item"
                                                href="namuna5_ahaval_samanyarokadvahi_masik.php">सामान्य रोकड
                                                वही(मासिक)</a>
                                            <a class="collapse-item"
                                                href="namuna5_ahaval_samanyarokadvahi_pavtinusar.php">सामान्य रोकड
                                                वही(पावती नुसार)</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>

                </li>
                <li class="nav-item">
                    <a class="nav-link ml-2 <?php //if ($subpage != 'ahaval') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapnamuna5c" aria-expanded="true"
                        aria-controls="collapseBootstrapnamuna5c">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>नमुना क्रमांक ५ ( क )</span>
                    </a>
                    <div id="collapseBootstrapnamuna5c"
                        class="collapse <?php //if ($subpage == 'ahaval') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <ul class="navbar-nav accordion" id="accordionSidebar8">

                                <li class="nav-item ml-3">
                                    <a class="nav-link <?php if ($subpage != 'yearlyWork') { echo 'collapsed'; } ?>"
                                        href="#" data-toggle="collapse" data-target="#collapseBootstrapnamuna5c_ahaval"
                                        aria-expanded="true" aria-controls="collapseBootstrapnamuna5c_ahaval">
                                        <i class="far fa-fw fa-window-maximize"></i>
                                        <span>अहवाल</span>
                                    </a>
                                    <div id="collapseBootstrapnamuna5c_ahaval"
                                        class="collapse <?php if ($subpage == 'yearlyWork') { echo 'show'; } ?>"
                                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <a class="collapse-item" href="namuna5_k_rokadvahi_dainandin.php">रोकड
                                                वही(दैनंदिन) </a>
                                            <a class="collapse-item" href="namuna5_k_rokadvahi.php">रोकड वही</a>
                                            <a class="collapse-item"
                                                href="namuna5_k_mahinyanusar_talmelpatrak.php">महिन्यानुसार ताळमेळ
                                                पत्रक</a>
                                            <a class="collapse-item" href="namuna5_k_varshik_talmelpatrak.php">वार्षिक
                                                ताळमेळ पत्रक </a>
                                            <a class="collapse-item"
                                                href="namuna5_k_mahinyanusar_jama_talmelpatrak.php">महिन्यानुसार जमा
                                                ताळमेळ पत्रक </a>
                                            <a class="collapse-item"
                                                href="namuna5_k_varshik_jama_talmelpatrak.php">वार्षिक जमा ताळमेळ पत्रक
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>

                </li>
                <li class="nav-item">
                    <a class="nav-link ml-2 <?php //if ($subpage != 'ahaval') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapnamuna6" aria-expanded="true"
                        aria-controls="collapseBootstrapnamuna6">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>नमुना क्रमांक ६</span>
                    </a>
                    <div id="collapseBootstrapnamuna6"
                        class="collapse <?php //if ($subpage == 'ahaval') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <ul class="navbar-nav accordion" id="accordionSidebar8">

                                <li class="nav-item ml-3">
                                    <a class="nav-link <?php if ($subpage != 'yearlyWork') { echo 'collapsed'; } ?>"
                                        href="#" data-toggle="collapse" data-target="#collapseBootstrapnamuna6_ahaval"
                                        aria-expanded="true" aria-controls="collapseBootstrapnamuna6_ahaval">
                                        <i class="far fa-fw fa-window-maximize"></i>
                                        <span>अहवाल</span>
                                    </a>
                                    <div id="collapseBootstrapnamuna6_ahaval"
                                        class="collapse <?php if ($subpage == 'yearlyWork') { echo 'show'; } ?>"
                                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <a class="collapse-item" href="alerts.html">जमा-खर्च चे वर्गीकरण</a>

                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>

                </li>
                <li class="nav-item">
                    <a class="nav-link ml-2 <?php //if ($subpage != 'ahaval') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapnamuna11" aria-expanded="true"
                        aria-controls="collapseBootstrapnamuna11">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>नमुना क्रमांक ११</span>
                    </a>
                    <div id="collapseBootstrapnamuna11"
                        class="collapse <?php //if ($subpage == 'ahaval') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <ul class="navbar-nav accordion" id="accordionSidebar8">

                                <li class="nav-item ml-3">
                                    <a class="nav-link <?php if ($subpage != 'yearlyWork') { echo 'collapsed'; } ?>"
                                        href="#" data-toggle="collapse" data-target="#collapseBootstrapnamuna11_ahaval"
                                        aria-expanded="true" aria-controls="collapseBootstrapnamuna11_ahaval">
                                        <i class="far fa-fw fa-window-maximize"></i>
                                        <span>अहवाल</span>
                                    </a>
                                    <div id="collapseBootstrapnamuna11_ahaval"
                                        class="collapse <?php if ($subpage == 'yearlyWork') { echo 'show'; } ?>"
                                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <a class="collapse-item" href="alerts.html">वार्षिक किरकोळ मागणी अहवाल</a>
                                        </div>
                                    </div>
                                </li>

                                <li class="nav-item ml-3">
                                    <a class="nav-link <?php if ($subpage != 'yearlyWork') { echo 'collapsed'; } ?>"
                                        href="#" data-toggle="collapse"
                                        data-target="#collapseBootstrapnamuna11_varshikkamkaj" aria-expanded="true"
                                        aria-controls="collapseBootstrapnamuna11_varshikkamkaj">
                                        <i class="far fa-fw fa-window-maximize"></i>
                                        <span>वार्षिक कामकाज</span>
                                    </a>
                                    <div id="collapseBootstrapnamuna11_varshikkamkaj"
                                        class="collapse <?php if ($subpage == 'yearlyWork') { echo 'show'; } ?>"
                                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <a class="collapse-item" href="alerts.html">किरकोळ कर मागणी</a>
                                            <a class="collapse-item" href="alerts.html">किरकोळ मागणी वसूल</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item ml-3">
                                    <a class="nav-link <?php if ($subpage != 'yearlyWork') { echo 'collapsed'; } ?>"
                                        href="#" data-toggle="collapse" data-target="#collapseBootstrapnamuna11_masters"
                                        aria-expanded="true" aria-controls="collapseBootstrapnamuna11_masters">
                                        <i class="far fa-fw fa-window-maximize"></i>
                                        <span>मास्टर्स</span>
                                    </a>
                                    <div id="collapseBootstrapnamuna11_masters"
                                        class="collapse <?php if ($subpage == 'yearlyWork') { echo 'show'; } ?>"
                                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <a class="collapse-item" href="alerts.html">किरकोळ मागणी स्वरुप</a>
                                            <a class="collapse-item" href="alerts.html">किरकोळ कर दर</a>
                                            <a class="collapse-item" href="alerts.html">किरकोळ मागणीदार नावे</a>
                                            <a class="collapse-item" href="alerts.html">नवीन नाव नोंदणी</a>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>

                    </div>

                </li>
                <li class="nav-item">
                    <a class="nav-link ml-2 <?php //if ($subpage != 'ahaval') { echo 'collapsed'; } ?>" href="#"
                        data-toggle="collapse" data-target="#collapseBootstrapnamuna13" aria-expanded="true"
                        aria-controls="collapseBootstrapnamuna13">
                        <i class="far fa-fw fa-window-maximize"></i>
                        <span>नमुना क्रमांक १३</span>
                    </a>
                    <div id="collapseBootstrapnamuna13"
                        class="collapse <?php //if ($subpage == 'ahaval') { echo 'show'; } ?>"
                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <ul class="navbar-nav accordion" id="accordionSidebar8">

                                <li class="nav-item ml-3">
                                    <a class="nav-link <?php if ($subpage != 'yearlyWork') { echo 'collapsed'; } ?>"
                                        href="#" data-toggle="collapse" data-target="#collapseBootstrapnamuna13_ahaval"
                                        aria-expanded="true" aria-controls="collapseBootstrapnamuna13_ahaval">
                                        <i class="far fa-fw fa-window-maximize"></i>
                                        <span>अहवाल</span>
                                    </a>
                                    <div id="collapseBootstrapnamuna13_ahaval"
                                        class="collapse <?php if ($subpage == 'yearlyWork') { echo 'show'; } ?>"
                                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <a class="collapse-item" href="alerts.html">कर्मचारी वर्गाची सूची
                                                व वेतन श्रेणी नोंद वही </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item ml-3">
                                    <a class="nav-link <?php if ($subpage != 'yearlyWork') { echo 'collapsed'; } ?>"
                                        href="#" data-toggle="collapse" data-target="#collapseBootstrapnamuna13_masters"
                                        aria-expanded="true" aria-controls="collapseBootstrapnamuna13_masters">
                                        <i class="far fa-fw fa-window-maximize"></i>
                                        <span>मास्टर्स</span>
                                    </a>
                                    <div id="collapseBootstrapnamuna13_masters"
                                        class="collapse <?php if ($subpage == 'yearlyWork') { echo 'show'; } ?>"
                                        aria-labelledby="headingBootstrap" data-parent="#accordionSidebar8">
                                        <div class="bg-white py-2 collapse-inner rounded">
                                            <a class="collapse-item" href="alerts.html">हुद्दा माहिती</a>
                                            <a class="collapse-item" href="alerts.html">कर्मचारी फंड</a>
                                            <a class="collapse-item" href="alerts.html">कर्मचारी माहिती</a>
                                            <a class="collapse-item" href="alerts.html">वेतनमान माहिती</a>
                                            <a class="collapse-item" href="alerts.html">कर्मचारी वर्गाची सूची</a>
                                            <a class="collapse-item" href="alerts.html">कर्मचारी वर्गाची श्रेणी</a>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>

                    </div>

                </li>
            </ul>
        </div>
    </li>

    <hr class="sidebar-divider">
    <!-- <div class="version" id="version-ruangadmin"></div> -->
</ul>
