<?php

/**
 * The template for displaying the footer
 */

wp_footer(); ?>


<footer>
    <div class="container">
        <div class="wrapper">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo"><img src="<?php echo get_template_directory_uri(); ?>/img/logo_footer.png" alt="" /></a>
            <div class="menus">
                <h2>О TALKORUS</h2>
                <nav>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/catalog/')); ?>">КАТАЛОГ</a></li>
                        <li><a href="<?php echo esc_url(get_term_link('dlya-doma', 'product_cat')); ?>">ДЛЯ ДОМА</a></li>
                        <li><a href="<?php echo esc_url(get_term_link('dlya-bani', 'product_cat')); ?>">ДЛЯ БАНИ</a></li>
                        <li><a href="<?php echo esc_url(get_term_link('plitka-i-kamni', 'product_cat')); ?>">ПЛИТКА И КАМНИ</a></li>
                        <li><a href="<?php echo esc_url(home_url('/projects/')); ?>">ПРОЕКТЫ</a></li>
                        <a href="#" class="site-map">Карта сайта</a>

                    </ul>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/kontakty/')); ?>">Контакты</a></li>
                        <li><a href="<?php echo esc_url(home_url('/usloviya-postavki/')); ?>">Оплата и доставка</a></li>
                        <li><a href="<?php echo esc_url(home_url('/usloviya-postavki/')); ?>">Гарантия и возврат</a></li>
                        <li><a href="<?php echo esc_url(home_url('/firmennye-pechi-kaminy-talkorus/')); ?>">Talkorus</a></li>
                        <li><a href="<?php echo esc_url(home_url('/nastoyashhie-pechi-dlya-russkoj-bani-talkorus-onego/')); ?>">Talkorus ОНЕГО</a></li>
                        <li class="contacts no-desctop">
                            <a href="tel:8800-201-14-19" class="phone">
                                <div class="icon">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="9"
                                        height="9"
                                        viewBox="0 0 9 9"
                                        fill="none">
                                        <g clip-path="url(#clip0_75_352)">
                                            <path
                                                d="M0.245622 3.8178C0.0866235 3.38832 -0.0285137 2.94971 0.00621022 2.48367C0.0281411 2.19674 0.135968 1.95185 0.346139 1.75082C0.574586 1.53516 0.79024 1.30854 1.01503 1.08923C1.30744 0.800478 1.67479 0.802305 1.9672 1.08923C2.14813 1.26651 2.32723 1.44744 2.50633 1.62837C2.67995 1.80199 2.8554 1.97561 3.02902 2.15106C3.33422 2.45992 3.33605 2.81995 3.03085 3.12698C2.81154 3.34629 2.59406 3.56743 2.37109 3.78308C2.31261 3.83973 2.30713 3.88725 2.3382 3.95853C2.4844 4.30942 2.6964 4.62194 2.93398 4.91435C3.41281 5.50283 3.95377 6.02551 4.59891 6.42941C4.7378 6.5153 4.88949 6.57927 5.03387 6.65785C5.1088 6.69806 5.15814 6.68527 5.21845 6.62313C5.43593 6.39834 5.6589 6.1772 5.88186 5.95607C6.17427 5.66731 6.53979 5.66548 6.8322 5.95607C7.19041 6.31061 7.54678 6.66699 7.90133 7.0252C8.19923 7.32492 8.1974 7.69226 7.89768 7.99381C7.69482 8.1985 7.48099 8.39222 7.29092 8.60605C7.01313 8.91674 6.66224 9.01908 6.26383 8.99715C5.68266 8.96608 5.14718 8.77236 4.62997 8.52198C3.48226 7.96457 2.50268 7.19151 1.6821 6.21558C1.07534 5.49186 0.574586 4.706 0.245622 3.8178ZM8.9997 4.47207C8.9997 2.00668 6.99303 0 4.52763 0V0.85165C6.52334 0.85165 8.14806 2.47636 8.14806 4.47207H8.9997ZM6.55076 4.47207H7.4024C7.4024 2.88757 6.11214 1.5973 4.52763 1.5973V2.44895C5.06859 2.44895 5.57666 2.65912 5.95862 3.04108C6.34058 3.42305 6.55076 3.93111 6.55076 4.47207Z"
                                                fill="#2F2F2F" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_75_352">
                                                <rect width="9" height="9" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                8800-201-14-19
                            </a>
                            <a href="mailto:ptk.10region@yandex.ru" class="mail">
                                <div class="icon">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="10"
                                        height="10"
                                        viewBox="0 0 10 10"
                                        fill="none">
                                        <path
                                            d="M9.9117 1.98682L6.87891 5.00008L9.9117 8.01334C9.96652 7.89875 9.99979 7.77207 9.99979 7.6368V2.36336C9.99979 2.22807 9.96652 2.10141 9.9117 1.98682Z"
                                            fill="#2F2F2F" />
                                        <path
                                            d="M9.12068 1.48438H0.878496C0.743203 1.48438 0.616543 1.51764 0.501953 1.57246L4.37818 5.42916C4.72092 5.77189 5.27826 5.77189 5.621 5.42916L9.49723 1.57246C9.38264 1.51764 9.25598 1.48438 9.12068 1.48438Z"
                                            fill="#2F2F2F" />
                                        <path
                                            d="M0.0880859 1.98682C0.0332617 2.10141 0 2.22807 0 2.36336V7.6368C0 7.77209 0.0332617 7.89877 0.0880859 8.01334L3.12088 5.00008L0.0880859 1.98682Z"
                                            fill="#2F2F2F" />
                                        <path
                                            d="M6.46443 5.41406L6.03527 5.84322C5.4642 6.4143 4.53496 6.4143 3.96389 5.84322L3.53475 5.41406L0.501953 8.42732C0.616543 8.48215 0.743203 8.51541 0.878496 8.51541H9.12068C9.25598 8.51541 9.38264 8.48215 9.49723 8.42732L6.46443 5.41406Z"
                                            fill="#2F2F2F" />
                                    </svg>
                                </div>
                                ptk.10region@yandex.ru
                            </a>
                            <div class="messgrs">
                                <a href="https://t.me/Talkorus" target="_blank">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="42"
                                        height="42"
                                        viewBox="0 0 42 42"
                                        fill="none">
                                        <g clip-path="url(#clip0_75_383)">
                                            <path
                                                d="M21 42C32.598 42 42 32.598 42 21C42 9.40202 32.598 0 21 0C9.40202 0 0 9.40202 0 21C0 32.598 9.40202 42 21 42Z"
                                                fill="#039BE5" />
                                            <path
                                                d="M9.60898 20.5449L29.8565 12.7381C30.7962 12.3986 31.617 12.9674 31.3125 14.3884L31.3142 14.3866L27.8667 30.6284C27.6112 31.7799 26.927 32.0599 25.9697 31.5174L20.7197 27.6481L18.1875 30.0876C17.9075 30.3676 17.6712 30.6039 17.1287 30.6039L17.5015 25.2611L27.2315 16.4709C27.655 16.0981 27.137 15.8881 26.5787 16.2591L14.5545 23.8296L9.37098 22.2126C8.24573 21.8556 8.22123 21.0874 9.60898 20.5449Z"
                                                fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_75_383">
                                                <rect width="42" height="42" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                                <a href="https://max.ru/u/f9LHodD0cOKmq1A0bbbV8BdjhVZ2m6-GAmIIXFXP8yaKcKjgWt3TDQ5xfGI" target="_blank">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/Max_logo_2025.png" alt="" />
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="contacts no-mobile">
                <a href="tel:8800-201-14-19" class="phone">
                    <div class="icon">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="9"
                            height="9"
                            viewBox="0 0 9 9"
                            fill="none">
                            <g clip-path="url(#clip0_75_352)">
                                <path
                                    d="M0.245622 3.8178C0.0866235 3.38832 -0.0285137 2.94971 0.00621022 2.48367C0.0281411 2.19674 0.135968 1.95185 0.346139 1.75082C0.574586 1.53516 0.79024 1.30854 1.01503 1.08923C1.30744 0.800478 1.67479 0.802305 1.9672 1.08923C2.14813 1.26651 2.32723 1.44744 2.50633 1.62837C2.67995 1.80199 2.8554 1.97561 3.02902 2.15106C3.33422 2.45992 3.33605 2.81995 3.03085 3.12698C2.81154 3.34629 2.59406 3.56743 2.37109 3.78308C2.31261 3.83973 2.30713 3.88725 2.3382 3.95853C2.4844 4.30942 2.6964 4.62194 2.93398 4.91435C3.41281 5.50283 3.95377 6.02551 4.59891 6.42941C4.7378 6.5153 4.88949 6.57927 5.03387 6.65785C5.1088 6.69806 5.15814 6.68527 5.21845 6.62313C5.43593 6.39834 5.6589 6.1772 5.88186 5.95607C6.17427 5.66731 6.53979 5.66548 6.8322 5.95607C7.19041 6.31061 7.54678 6.66699 7.90133 7.0252C8.19923 7.32492 8.1974 7.69226 7.89768 7.99381C7.69482 8.1985 7.48099 8.39222 7.29092 8.60605C7.01313 8.91674 6.66224 9.01908 6.26383 8.99715C5.68266 8.96608 5.14718 8.77236 4.62997 8.52198C3.48226 7.96457 2.50268 7.19151 1.6821 6.21558C1.07534 5.49186 0.574586 4.706 0.245622 3.8178ZM8.9997 4.47207C8.9997 2.00668 6.99303 0 4.52763 0V0.85165C6.52334 0.85165 8.14806 2.47636 8.14806 4.47207H8.9997ZM6.55076 4.47207H7.4024C7.4024 2.88757 6.11214 1.5973 4.52763 1.5973V2.44895C5.06859 2.44895 5.57666 2.65912 5.95862 3.04108C6.34058 3.42305 6.55076 3.93111 6.55076 4.47207Z"
                                    fill="#2F2F2F" />
                            </g>
                            <defs>
                                <clipPath id="clip0_75_352">
                                    <rect width="9" height="9" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    8800-201-14-19
                </a>
                <a href="mailto:ptk.10region@yandex.ru" class="mail">
                    <div class="icon">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="10"
                            height="10"
                            viewBox="0 0 10 10"
                            fill="none">
                            <path
                                d="M9.9117 1.98682L6.87891 5.00008L9.9117 8.01334C9.96652 7.89875 9.99979 7.77207 9.99979 7.6368V2.36336C9.99979 2.22807 9.96652 2.10141 9.9117 1.98682Z"
                                fill="#2F2F2F" />
                            <path
                                d="M9.12068 1.48438H0.878496C0.743203 1.48438 0.616543 1.51764 0.501953 1.57246L4.37818 5.42916C4.72092 5.77189 5.27826 5.77189 5.621 5.42916L9.49723 1.57246C9.38264 1.51764 9.25598 1.48438 9.12068 1.48438Z"
                                fill="#2F2F2F" />
                            <path
                                d="M0.0880859 1.98682C0.0332617 2.10141 0 2.22807 0 2.36336V7.6368C0 7.77209 0.0332617 7.89877 0.0880859 8.01334L3.12088 5.00008L0.0880859 1.98682Z"
                                fill="#2F2F2F" />
                            <path
                                d="M6.46443 5.41406L6.03527 5.84322C5.4642 6.4143 4.53496 6.4143 3.96389 5.84322L3.53475 5.41406L0.501953 8.42732C0.616543 8.48215 0.743203 8.51541 0.878496 8.51541H9.12068C9.25598 8.51541 9.38264 8.48215 9.49723 8.42732L6.46443 5.41406Z"
                                fill="#2F2F2F" />
                        </svg>
                    </div>
                    ptk.10region@yandex.ru
                </a>
                <div class="messgrs">
                    <a href="https://t.me/Talkorus" target="_blank">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="42"
                            height="42"
                            viewBox="0 0 42 42"
                            fill="none">
                            <g clip-path="url(#clip0_75_383)">
                                <path
                                    d="M21 42C32.598 42 42 32.598 42 21C42 9.40202 32.598 0 21 0C9.40202 0 0 9.40202 0 21C0 32.598 9.40202 42 21 42Z"
                                    fill="#039BE5" />
                                <path
                                    d="M9.60898 20.5449L29.8565 12.7381C30.7962 12.3986 31.617 12.9674 31.3125 14.3884L31.3142 14.3866L27.8667 30.6284C27.6112 31.7799 26.927 32.0599 25.9697 31.5174L20.7197 27.6481L18.1875 30.0876C17.9075 30.3676 17.6712 30.6039 17.1287 30.6039L17.5015 25.2611L27.2315 16.4709C27.655 16.0981 27.137 15.8881 26.5787 16.2591L14.5545 23.8296L9.37098 22.2126C8.24573 21.8556 8.22123 21.0874 9.60898 20.5449Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_75_383">
                                    <rect width="42" height="42" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </a>
                    <a href="https://max.ru/u/f9LHodD0cOKmq1A0bbbV8BdjhVZ2m6-GAmIIXFXP8yaKcKjgWt3TDQ5xfGI" target="_blank">
                        <img src="<?php echo get_template_directory_uri(); ?>/img/Max_logo_2025.png" alt="" />
                    </a>
                </div>
            </div>
            <div class="infos">
                <h2>
                    ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ<br />
                    “ТАЛЬКОРУС”
                </h2>
                <div class="address">
                    185509, Республика Карелия,<br />
                    г. Петрозаводск, пос. Мелиоративный,<br />
                    ул. Лесная, д.2-А<br />

                    ИНН: <span>100&#8203;123&#8203;2278</span>
                </div>
                <a href="#" class="politic">Политика конфиденциальности</a>
                <div class="karelia">
                    <img src="<?php echo get_template_directory_uri(); ?>/img/mybusiness.png" alt="" />
                    Сайт создан при поддержке Центра<br />
                    «Мой бизнес» Республики Карелия
                </div>
            </div>
        </div>
    </div>
</footer>
<?php if (function_exists('WC') && ! is_cart()) : ?>
    <?php
    $cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    ?>

    <a
        href="<?php echo esc_url(wc_get_cart_url()); ?>"
        class="floating-cart <?php echo $cart_count > 0 ? 'is-visible' : ''; ?>"
        aria-label="Перейти в корзину">
        <span class="floating-cart__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M7.2 19.2C6.5373 19.2 6 19.7373 6 20.4C6 21.0627 6.5373 21.6 7.2 21.6C7.8627 21.6 8.4 21.0627 8.4 20.4C8.4 19.7373 7.8627 19.2 7.2 19.2Z" fill="currentColor" />
                <path d="M18 19.2C17.3373 19.2 16.8 19.7373 16.8 20.4C16.8 21.0627 17.3373 21.6 18 21.6C18.6627 21.6 19.2 21.0627 19.2 20.4C19.2 19.7373 18.6627 19.2 18 19.2Z" fill="currentColor" />
                <path d="M3 3.6H5.082L6.81 15.192C6.9348 16.0308 7.6554 16.65 8.5032 16.65H18.2556C19.0614 16.65 19.7586 16.0872 19.929 15.3L21.186 9.492C21.399 8.508 20.649 7.575 19.6422 7.575H7.302L6.915 4.977C6.795 4.1706 6.1026 3.6 5.2872 3.6H3C2.6688 3.6 2.4 3.8688 2.4 4.2C2.4 4.5312 2.6688 4.8 3 4.8ZM7.482 8.775H19.6422C19.884 8.775 20.064 8.9994 20.0124 9.2358L18.7554 15.0438C18.7044 15.2796 18.4956 15.45 18.2556 15.45H8.5032C8.2506 15.45 8.0358 15.2652 7.9992 15.0156L7.482 8.775Z" fill="currentColor" />
            </svg>
        </span>

        <span class="floating-cart__count">
            <?php echo esc_html($cart_count); ?>
        </span>
    </a>
<?php endif; ?>

<div class="video-modal" id="videoModal" aria-hidden="true">
    <div class="video-modal__overlay" data-video-close></div>

    <div class="video-modal__content">
        <button class="video-modal__close" type="button" data-video-close aria-label="Закрыть видео">
            ×
        </button>

        <video class="video-modal__video" controls playsinline>
            <source src="" type="video/mp4">
        </video>
    </div>
</div>
</body>

</html>