<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Enums\SettingType;
use Illuminate\Database\Seeder;

class LegalContentSeeder extends Seeder
{
    public function run(): void
    {
        $legalContent = [
            // Privacy Policy
            'privacy_policy_title' => [
                'en' => 'Privacy Policy',
                'ar' => 'سياسة الخصوصية',
            ],
            'privacy_policy_content' => [
                'en' => $this->getPrivacyPolicyEn(),
                'ar' => $this->getPrivacyPolicyAr(),
            ],

            // Terms of Service
            'terms_of_service_title' => [
                'en' => 'Terms of Service',
                'ar' => 'شروط الخدمة',
            ],
            'terms_of_service_content' => [
                'en' => $this->getTermsOfServiceEn(),
                'ar' => $this->getTermsOfServiceAr(),
            ],

            // Cookie Policy
            'cookie_policy_title' => [
                'en' => 'Cookie Policy',
                'ar' => 'سياسة ملفات تعريف الارتباط',
            ],
            'cookie_policy_content' => [
                'en' => $this->getCookiePolicyEn(),
                'ar' => $this->getCookiePolicyAr(),
            ],

            // Refund Policy
            'refund_policy_title' => [
                'en' => 'Refund Policy',
                'ar' => 'سياسة الاسترداد',
            ],
            'refund_policy_content' => [
                'en' => $this->getRefundPolicyEn(),
                'ar' => $this->getRefundPolicyAr(),
            ],

            // Shipping Policy
            'shipping_policy_title' => [
                'en' => 'Shipping Policy',
                'ar' => 'سياسة الشحن',
            ],
            'shipping_policy_content' => [
                'en' => $this->getShippingPolicyEn(),
                'ar' => $this->getShippingPolicyAr(),
            ],
        ];

        foreach ($legalContent as $key => $translations) {
            $type = str_ends_with($key, '_title') ? SettingType::Text : SettingType::Json;
            $group = 'legal';

            $setting = Setting::updateOrCreate(
                ['key' => $key],
                [
                    'type' => $type,
                    'group' => $group,
                    'is_public' => true,
                    'description' => [
                        'en' => 'Legal content for car export business',
                        'ar' => 'المحتوى القانوني لأعمال تصدير السيارات',
                    ],
                    'order' => match (true) {
                        str_contains($key, 'privacy_policy') => str_ends_with($key, '_title') ? 1 : 2,
                        str_contains($key, 'terms_of_service') => str_ends_with($key, '_title') ? 3 : 4,
                        str_contains($key, 'cookie_policy') => str_ends_with($key, '_title') ? 5 : 6,
                        str_contains($key, 'refund_policy') => str_ends_with($key, '_title') ? 7 : 8,
                        str_contains($key, 'shipping_policy') => str_ends_with($key, '_title') ? 9 : 10,
                        default => 99,
                    },
                ]
            );

            // Set the value after creation to ensure proper handling of translatable content
            $setting->value = $translations;
            $setting->save();
        }

        $this->command->info('Legal content seeded successfully!');
    }

    private function getPrivacyPolicyEn(): string
    {
        return '<h1>Privacy Policy</h1>

<p><strong>Effective Date:</strong> ' . now()->format('F j, Y') . '</p>

<h2>1. Information We Collect</h2>
<p>Elite Car Export ("we," "our," or "us") collects information to provide better services to our customers. We collect information in the following ways:</p>

<h3>1.1 Information You Provide</h3>
<ul>
<li><strong>Contact Information:</strong> Name, email address, phone number, and mailing address</li>
<li><strong>Business Information:</strong> Company name, business license, and tax identification</li>
<li><strong>Vehicle Preferences:</strong> Car specifications, budget, and delivery requirements</li>
<li><strong>Communication Records:</strong> Emails, phone calls, and chat messages</li>
</ul>

<h3>1.2 Information We Collect Automatically</h3>
<ul>
<li><strong>Website Usage:</strong> Pages visited, time spent, and click patterns</li>
<li><strong>Device Information:</strong> IP address, browser type, and operating system</li>
<li><strong>Cookies:</strong> As described in our Cookie Policy</li>
</ul>

<h2>2. How We Use Your Information</h2>
<p>We use your information to:</p>
<ul>
<li>Process vehicle export requests and transactions</li>
<li>Provide customer support and communication</li>
<li>Comply with legal and regulatory requirements</li>
<li>Improve our services and website functionality</li>
<li>Send marketing communications (with your consent)</li>
<li>Prevent fraud and ensure security</li>
</ul>

<h2>3. Information Sharing</h2>
<p>We may share your information with:</p>
<ul>
<li><strong>Service Providers:</strong> Shipping companies, customs brokers, and payment processors</li>
<li><strong>Business Partners:</strong> Car manufacturers and dealerships</li>
<li><strong>Legal Authorities:</strong> When required by law or to protect our rights</li>
<li><strong>Business Transfers:</strong> In case of merger, acquisition, or sale of assets</li>
</ul>

<h2>4. Data Security</h2>
<p>We implement appropriate security measures to protect your personal information, including:</p>
<ul>
<li>SSL encryption for data transmission</li>
<li>Secure servers and databases</li>
<li>Regular security audits and updates</li>
<li>Limited access to personal information</li>
</ul>

<h2>5. Your Rights</h2>
<p>You have the right to:</p>
<ul>
<li>Access your personal information</li>
<li>Correct inaccurate information</li>
<li>Delete your personal information</li>
<li>Restrict processing of your information</li>
<li>Data portability</li>
<li>Object to processing</li>
</ul>

<h2>6. International Transfers</h2>
<p>As we operate internationally, your information may be transferred to and processed in countries other than your country of residence. We ensure appropriate safeguards are in place for such transfers.</p>

<h2>7. Retention Period</h2>
<p>We retain your personal information for as long as necessary to fulfill the purposes outlined in this policy, typically for 7 years after the completion of services or as required by law.</p>

<h2>8. Contact Us</h2>
<p>If you have questions about this Privacy Policy, please contact us:</p>
<ul>
<li><strong>Email:</strong> privacy@elitecarexport.com</li>
<li><strong>Phone:</strong> +49 123 456 7890</li>
<li><strong>Address:</strong> Elite Car Export GmbH, Musterstraße 123, 12345 Berlin, Germany</li>
</ul>';
    }

    private function getPrivacyPolicyAr(): string
    {
        return '<h1>سياسة الخصوصية</h1>

<p><strong>تاريخ السريان:</strong> ' . now()->format('F j, Y') . '</p>

<h2>1. المعلومات التي نجمعها</h2>
<p>شركة تصدير السيارات النخبة ("نحن" أو "لنا") تجمع المعلومات لتقديم خدمات أفضل لعملائنا. نجمع المعلومات بالطرق التالية:</p>

<h3>1.1 المعلومات التي تقدمها</h3>
<ul>
<li><strong>معلومات الاتصال:</strong> الاسم وعنوان البريد الإلكتروني ورقم الهاتف والعنوان البريدي</li>
<li><strong>معلومات العمل:</strong> اسم الشركة ورخصة العمل ورقم التعريف الضريبي</li>
<li><strong>تفضيلات المركبات:</strong> مواصفات السيارة والميزانية ومتطلبات التسليم</li>
<li><strong>سجلات التواصل:</strong> رسائل البريد الإلكتروني والمكالمات الهاتفية ورسائل الدردشة</li>
</ul>

<h3>1.2 المعلومات التي نجمعها تلقائياً</h3>
<ul>
<li><strong>استخدام الموقع:</strong> الصفحات المزارة والوقت المستغرق وأنماط النقر</li>
<li><strong>معلومات الجهاز:</strong> عنوان IP ونوع المتصفح ونظام التشغيل</li>
<li><strong>ملفات تعريف الارتباط:</strong> كما هو موضح في سياسة ملفات تعريف الارتباط</li>
</ul>

<h2>2. كيف نستخدم معلوماتك</h2>
<p>نستخدم معلوماتك لـ:</p>
<ul>
<li>معالجة طلبات تصدير المركبات والمعاملات</li>
<li>تقديم دعم العملاء والتواصل</li>
<li>الامتثال للمتطلبات القانونية والتنظيمية</li>
<li>تحسين خدماتنا ووظائف الموقع</li>
<li>إرسال الاتصالات التسويقية (بموافقتك)</li>
<li>منع الاحتيال وضمان الأمان</li>
</ul>

<h2>3. مشاركة المعلومات</h2>
<p>قد نشارك معلوماتك مع:</p>
<ul>
<li><strong>مقدمي الخدمات:</strong> شركات الشحن ووسطاء الجمارك ومعالجي المدفوعات</li>
<li><strong>شركاء العمل:</strong> مصنعي السيارات والوكلاء</li>
<li><strong>السلطات القانونية:</strong> عند طلب القانون أو لحماية حقوقنا</li>
<li><strong>التحويلات التجارية:</strong> في حالة الاندماج أو الاستحواذ أو بيع الأصول</li>
</ul>

<h2>4. أمان البيانات</h2>
<p>نطبق تدابير أمنية مناسبة لحماية معلوماتك الشخصية، بما في ذلك:</p>
<ul>
<li>تشفير SSL لنقل البيانات</li>
<li>خوادم وقواعد بيانات آمنة</li>
<li>عمليات تدقيق وتحديثات أمنية منتظمة</li>
<li>وصول محدود للمعلومات الشخصية</li>
</ul>

<h2>5. حقوقك</h2>
<p>لديك الحق في:</p>
<ul>
<li>الوصول إلى معلوماتك الشخصية</li>
<li>تصحيح المعلومات غير الدقيقة</li>
<li>حذف معلوماتك الشخصية</li>
<li>تقييد معالجة معلوماتك</li>
<li>قابلية نقل البيانات</li>
<li>الاعتراض على المعالجة</li>
</ul>

<h2>6. التحويلات الدولية</h2>
<p>بما أننا نعمل دولياً، قد يتم نقل معلوماتك ومعالجتها في بلدان غير بلد إقامتك. نضمن وجود ضمانات مناسبة لمثل هذه التحويلات.</p>

<h2>7. فترة الاحتفاظ</h2>
<p>نحتفظ بمعلوماتك الشخصية للمدة اللازمة لتحقيق الأغراض المبينة في هذه السياسة، عادة لمدة 7 سنوات بعد إتمام الخدمات أو حسب ما يقتضيه القانون.</p>

<h2>8. اتصل بنا</h2>
<p>إذا كان لديك أسئلة حول سياسة الخصوصية هذه، يرجى الاتصال بنا:</p>
<ul>
<li><strong>البريد الإلكتروني:</strong> privacy@elitecarexport.com</li>
<li><strong>الهاتف:</strong> +49 123 456 7890</li>
<li><strong>العنوان:</strong> Elite Car Export GmbH, Musterstraße 123, 12345 Berlin, Germany</li>
</ul>';
    }

    private function getTermsOfServiceEn(): string
    {
        return '<h1>Terms of Service</h1>

<p><strong>Effective Date:</strong> ' . now()->format('F j, Y') . '</p>

<h2>1. Acceptance of Terms</h2>
<p>By accessing and using Elite Car Export services, you accept and agree to be bound by the terms and provision of this agreement.</p>

<h2>2. Services Description</h2>
<p>Elite Car Export provides:</p>
<ul>
<li>Vehicle sourcing from European markets</li>
<li>Export documentation and customs clearance</li>
<li>Shipping and logistics coordination</li>
<li>Post-delivery support and warranty assistance</li>
</ul>

<h2>3. Customer Obligations</h2>
<p>As a customer, you agree to:</p>
<ul>
<li>Provide accurate and complete information</li>
<li>Pay all fees and charges in a timely manner</li>
<li>Comply with all applicable laws and regulations</li>
<li>Obtain necessary import licenses and permits</li>
<li>Arrange appropriate insurance coverage</li>
</ul>

<h2>4. Payment Terms</h2>
<ul>
<li><strong>Deposit:</strong> 30% upon order confirmation</li>
<li><strong>Balance:</strong> 70% before vehicle shipment</li>
<li><strong>Payment Methods:</strong> Bank transfer, letter of credit</li>
<li><strong>Currency:</strong> EUR or USD as agreed</li>
<li><strong>Late Payment:</strong> 2% monthly interest on overdue amounts</li>
</ul>

<h2>5. Delivery and Risk Transfer</h2>
<ul>
<li>Risk transfers to buyer upon vehicle loading at origin port</li>
<li>Delivery times are estimates and subject to shipping schedules</li>
<li>Force majeure events may delay delivery without liability</li>
<li>Customer responsible for customs clearance at destination</li>
</ul>

<h2>6. Warranties and Disclaimers</h2>
<p>We warrant that:</p>
<ul>
<li>Vehicles will match specifications as agreed</li>
<li>All documentation will be accurate and complete</li>
<li>Services will be performed with professional care</li>
</ul>

<p><strong>Disclaimer:</strong> We disclaim all other warranties, express or implied, including merchantability and fitness for a particular purpose.</p>

<h2>7. Limitation of Liability</h2>
<p>Our liability is limited to:</p>
<ul>
<li>Direct damages only</li>
<li>Maximum amount equal to the vehicle purchase price</li>
<li>No liability for consequential or indirect damages</li>
<li>Claims must be made within 30 days of delivery</li>
</ul>

<h2>8. Cancellation Policy</h2>
<ul>
<li><strong>Before Vehicle Purchase:</strong> Full refund minus 5% processing fee</li>
<li><strong>After Vehicle Purchase:</strong> Refund minus actual costs incurred</li>
<li><strong>After Shipment:</strong> No refund available</li>
<li><strong>Force Majeure:</strong> Pro-rata refund of undelivered services</li>
</ul>

<h2>9. Intellectual Property</h2>
<p>All content, trademarks, and intellectual property remain our exclusive property. Customers may not reproduce or distribute our materials without written permission.</p>

<h2>10. Governing Law</h2>
<p>These terms are governed by German law. Any disputes will be resolved through arbitration in Berlin, Germany.</p>

<h2>11. Contact Information</h2>
<p>For questions about these terms:</p>
<ul>
<li><strong>Email:</strong> legal@elitecarexport.com</li>
<li><strong>Phone:</strong> +49 123 456 7890</li>
<li><strong>Address:</strong> Elite Car Export GmbH, Musterstraße 123, 12345 Berlin, Germany</li>
</ul>';
    }

    private function getTermsOfServiceAr(): string
    {
        return '<h1>شروط الخدمة</h1>

<p><strong>تاريخ السريان:</strong> ' . now()->format('F j, Y') . '</p>

<h2>1. قبول الشروط</h2>
<p>بالوصول إلى خدمات تصدير السيارات النخبة واستخدامها، فإنك تقبل وتوافق على الالتزام بشروط وأحكام هذه الاتفاقية.</p>

<h2>2. وصف الخدمات</h2>
<p>تقدم شركة تصدير السيارات النخبة:</p>
<ul>
<li>توريد المركبات من الأسواق الأوروبية</li>
<li>وثائق التصدير وتخليص الجمارك</li>
<li>تنسيق الشحن واللوجستيات</li>
<li>الدعم بعد التسليم ومساعدة الضمان</li>
</ul>

<h2>3. التزامات العميل</h2>
<p>كعميل، فإنك توافق على:</p>
<ul>
<li>تقديم معلومات دقيقة وكاملة</li>
<li>دفع جميع الرسوم والتكاليف في الوقت المناسب</li>
<li>الامتثال لجميع القوانين واللوائح المعمول بها</li>
<li>الحصول على تراخيص وتصاريح الاستيراد اللازمة</li>
<li>ترتيب التغطية التأمينية المناسبة</li>
</ul>

<h2>4. شروط الدفع</h2>
<ul>
<li><strong>الدفعة المقدمة:</strong> 30% عند تأكيد الطلب</li>
<li><strong>الرصيد:</strong> 70% قبل شحن المركبة</li>
<li><strong>طرق الدفع:</strong> تحويل مصرفي، خطاب اعتماد</li>
<li><strong>العملة:</strong> اليورو أو الدولار الأمريكي حسب الاتفاق</li>
<li><strong>التأخير في الدفع:</strong> فائدة شهرية 2% على المبالغ المتأخرة</li>
</ul>

<h2>5. التسليم ونقل المخاطر</h2>
<ul>
<li>تنتقل المخاطر إلى المشتري عند تحميل المركبة في ميناء المنشأ</li>
<li>أوقات التسليم تقديرية وتخضع لجداول الشحن</li>
<li>أحداث القوة القاهرة قد تؤخر التسليم دون مسؤولية</li>
<li>العميل مسؤول عن تخليص الجمارك في الوجهة</li>
</ul>

<h2>6. الضمانات وإخلاء المسؤولية</h2>
<p>نضمن أن:</p>
<ul>
<li>المركبات ستطابق المواصفات المتفق عليها</li>
<li>جميع الوثائق ستكون دقيقة وكاملة</li>
<li>الخدمات ستُؤدى بعناية مهنية</li>
</ul>

<p><strong>إخلاء المسؤولية:</strong> نخلي مسؤوليتنا عن جميع الضمانات الأخرى، صريحة أو ضمنية، بما في ذلك القابلية للتسويق والملاءمة لغرض معين.</p>

<h2>7. حدود المسؤولية</h2>
<p>مسؤوليتنا محدودة بـ:</p>
<ul>
<li>الأضرار المباشرة فقط</li>
<li>الحد الأقصى يساوي سعر شراء المركبة</li>
<li>لا مسؤولية عن الأضرار التبعية أو غير المباشرة</li>
<li>يجب تقديم المطالبات خلال 30 يوماً من التسليم</li>
</ul>

<h2>8. سياسة الإلغاء</h2>
<ul>
<li><strong>قبل شراء المركبة:</strong> استرداد كامل ناقص 5% رسوم معالجة</li>
<li><strong>بعد شراء المركبة:</strong> استرداد ناقص التكاليف الفعلية المتكبدة</li>
<li><strong>بعد الشحن:</strong> لا يتوفر استرداد</li>
<li><strong>القوة القاهرة:</strong> استرداد تناسبي للخدمات غير المسلمة</li>
</ul>

<h2>9. الملكية الفكرية</h2>
<p>جميع المحتويات والعلامات التجارية والملكية الفكرية تبقى ملكيتنا الحصرية. لا يجوز للعملاء إعادة إنتاج أو توزيع موادنا دون إذن كتابي.</p>

<h2>10. القانون الحاكم</h2>
<p>تخضع هذه الشروط للقانون الألماني. ستُحل أي نزاعات من خلال التحكيم في برلين، ألمانيا.</p>

<h2>11. معلومات الاتصال</h2>
<p>للاستفسار عن هذه الشروط:</p>
<ul>
<li><strong>البريد الإلكتروني:</strong> legal@elitecarexport.com</li>
<li><strong>الهاتف:</strong> +49 123 456 7890</li>
<li><strong>العنوان:</strong> Elite Car Export GmbH, Musterstraße 123, 12345 Berlin, Germany</li>
</ul>';
    }

    private function getCookiePolicyEn(): string
    {
        return '<h1>Cookie Policy</h1>

<p><strong>Effective Date:</strong> ' . now()->format('F j, Y') . '</p>

<h2>1. What Are Cookies</h2>
<p>Cookies are small text files stored on your device when you visit our website. They help us provide you with a better browsing experience and enable certain website functions.</p>

<h2>2. Types of Cookies We Use</h2>

<h3>2.1 Essential Cookies</h3>
<p>These cookies are necessary for the website to function properly:</p>
<ul>
<li><strong>Session Cookies:</strong> Maintain your session while browsing</li>
<li><strong>Security Cookies:</strong> Protect against fraudulent activity</li>
<li><strong>Load Balancing:</strong> Distribute traffic across our servers</li>
</ul>

<h3>2.2 Functional Cookies</h3>
<p>These cookies enhance your browsing experience:</p>
<ul>
<li><strong>Language Preferences:</strong> Remember your language choice</li>
<li><strong>Form Data:</strong> Save partially completed forms</li>
<li><strong>User Interface:</strong> Remember your display preferences</li>
</ul>

<h3>2.3 Analytics Cookies</h3>
<p>These cookies help us understand how visitors use our website:</p>
<ul>
<li><strong>Google Analytics:</strong> Track page views and user behavior</li>
<li><strong>Performance Monitoring:</strong> Identify technical issues</li>
<li><strong>Usage Statistics:</strong> Understand popular content</li>
</ul>

<h3>2.4 Marketing Cookies</h3>
<p>These cookies are used for advertising and marketing purposes:</p>
<ul>
<li><strong>Remarketing:</strong> Show relevant ads on other websites</li>
<li><strong>Social Media:</strong> Enable sharing and social media features</li>
<li><strong>Campaign Tracking:</strong> Measure marketing effectiveness</li>
</ul>

<h2>3. Third-Party Cookies</h2>
<p>We may use third-party services that set their own cookies:</p>
<ul>
<li><strong>Google Analytics:</strong> Website analytics and reporting</li>
<li><strong>Google Ads:</strong> Advertising and remarketing</li>
<li><strong>Facebook Pixel:</strong> Social media advertising</li>
<li><strong>YouTube:</strong> Video content embedding</li>
</ul>

<h2>4. Managing Cookies</h2>

<h3>4.1 Browser Settings</h3>
<p>You can control cookies through your browser settings:</p>
<ul>
<li>Block all cookies</li>
<li>Accept only first-party cookies</li>
<li>Delete existing cookies</li>
<li>Set up automatic deletion</li>
</ul>

<h3>4.2 Opt-Out Links</h3>
<ul>
<li><a href="https://tools.google.com/dlpage/gaoptout" target="_blank">Google Analytics Opt-out</a></li>
<li><a href="https://www.google.com/settings/ads" target="_blank">Google Ads Settings</a></li>
<li><a href="https://www.facebook.com/ads/preferences" target="_blank">Facebook Ad Preferences</a></li>
</ul>

<h2>5. Cookie Consent</h2>
<p>By continuing to use our website, you consent to our use of cookies as described in this policy. You can withdraw consent at any time by adjusting your browser settings.</p>

<h2>6. Updates to This Policy</h2>
<p>We may update this Cookie Policy periodically. We will notify you of any significant changes by posting the new policy on our website.</p>

<h2>7. Contact Us</h2>
<p>If you have questions about our use of cookies:</p>
<ul>
<li><strong>Email:</strong> privacy@elitecarexport.com</li>
<li><strong>Phone:</strong> +49 123 456 7890</li>
<li><strong>Address:</strong> Elite Car Export GmbH, Musterstraße 123, 12345 Berlin, Germany</li>
</ul>';
    }

    private function getCookiePolicyAr(): string
    {
        return '<h1>سياسة ملفات تعريف الارتباط</h1>

<p><strong>تاريخ السريان:</strong> ' . now()->format('F j, Y') . '</p>

<h2>1. ما هي ملفات تعريف الارتباط</h2>
<p>ملفات تعريف الارتباط هي ملفات نصية صغيرة يتم تخزينها على جهازك عند زيارة موقعنا الإلكتروني. تساعدنا في تزويدك بتجربة تصفح أفضل وتمكين وظائف معينة في الموقع.</p>

<h2>2. أنواع ملفات تعريف الارتباط التي نستخدمها</h2>

<h3>2.1 ملفات تعريف الارتباط الأساسية</h3>
<p>هذه الملفات ضرورية لعمل الموقع بشكل صحيح:</p>
<ul>
<li><strong>ملفات الجلسة:</strong> للحفاظ على جلستك أثناء التصفح</li>
<li><strong>ملفات الأمان:</strong> للحماية من النشاط الاحتيالي</li>
<li><strong>توزيع الحمولة:</strong> لتوزيع حركة المرور عبر خوادمنا</li>
</ul>

<h3>2.2 ملفات تعريف الارتباط الوظيفية</h3>
<p>هذه الملفات تعزز تجربة التصفح:</p>
<ul>
<li><strong>تفضيلات اللغة:</strong> لتذكر اختيار اللغة</li>
<li><strong>بيانات النماذج:</strong> لحفظ النماذج المكتملة جزئياً</li>
<li><strong>واجهة المستخدم:</strong> لتذكر تفضيلات العرض</li>
</ul>

<h3>2.3 ملفات تعريف الارتباط التحليلية</h3>
<p>هذه الملفات تساعدنا في فهم كيفية استخدام الزوار لموقعنا:</p>
<ul>
<li><strong>Google Analytics:</strong> لتتبع مشاهدات الصفحة وسلوك المستخدم</li>
<li><strong>مراقبة الأداء:</strong> لتحديد المشاكل التقنية</li>
<li><strong>إحصائيات الاستخدام:</strong> لفهم المحتوى الشائع</li>
</ul>

<h3>2.4 ملفات تعريف الارتباط التسويقية</h3>
<p>هذه الملفات تُستخدم لأغراض الإعلان والتسويق:</p>
<ul>
<li><strong>إعادة التسويق:</strong> لعرض إعلانات ذات صلة على مواقع أخرى</li>
<li><strong>وسائل التواصل الاجتماعي:</strong> لتمكين المشاركة وميزات وسائل التواصل الاجتماعي</li>
<li><strong>تتبع الحملات:</strong> لقياس فعالية التسويق</li>
</ul>

<h2>3. ملفات تعريف الارتباط من جهات خارجية</h2>
<p>قد نستخدم خدمات جهات خارجية تضع ملفات تعريف الارتباط الخاصة بها:</p>
<ul>
<li><strong>Google Analytics:</strong> تحليلات الموقع والتقارير</li>
<li><strong>Google Ads:</strong> الإعلان وإعادة التسويق</li>
<li><strong>Facebook Pixel:</strong> إعلانات وسائل التواصل الاجتماعي</li>
<li><strong>YouTube:</strong> تضمين محتوى الفيديو</li>
</ul>

<h2>4. إدارة ملفات تعريف الارتباط</h2>

<h3>4.1 إعدادات المتصفح</h3>
<p>يمكنك التحكم في ملفات تعريف الارتباط من خلال إعدادات المتصفح:</p>
<ul>
<li>حظر جميع ملفات تعريف الارتباط</li>
<li>قبول ملفات تعريف الارتباط من الطرف الأول فقط</li>
<li>حذف ملفات تعريف الارتباط الموجودة</li>
<li>إعداد الحذف التلقائي</li>
</ul>

<h3>4.2 روابط إلغاء الاشتراك</h3>
<ul>
<li><a href="https://tools.google.com/dlpage/gaoptout" target="_blank">إلغاء الاشتراك في Google Analytics</a></li>
<li><a href="https://www.google.com/settings/ads" target="_blank">إعدادات إعلانات Google</a></li>
<li><a href="https://www.facebook.com/ads/preferences" target="_blank">تفضيلات إعلانات Facebook</a></li>
</ul>

<h2>5. موافقة ملفات تعريف الارتباط</h2>
<p>بمواصلة استخدام موقعنا، فإنك توافق على استخدامنا لملفات تعريف الارتباط كما هو موضح في هذه السياسة. يمكنك سحب الموافقة في أي وقت عن طريق تعديل إعدادات المتصفح.</p>

<h2>6. تحديثات هذه السياسة</h2>
<p>قد نقوم بتحديث سياسة ملفات تعريف الارتباط هذه بشكل دوري. سنخطرك بأي تغييرات مهمة من خلال نشر السياسة الجديدة على موقعنا.</p>

<h2>7. اتصل بنا</h2>
<p>إذا كان لديك أسئلة حول استخدامنا لملفات تعريف الارتباط:</p>
<ul>
<li><strong>البريد الإلكتروني:</strong> privacy@elitecarexport.com</li>
<li><strong>الهاتف:</strong> +49 123 456 7890</li>
<li><strong>العنوان:</strong> Elite Car Export GmbH, Musterstraße 123, 12345 Berlin, Germany</li>
</ul>';
    }

    private function getRefundPolicyEn(): string
    {
        return '<h1>Refund Policy</h1>

<p><strong>Effective Date:</strong> ' . now()->format('F j, Y') . '</p>

<h2>1. General Refund Policy</h2>
<p>Elite Car Export is committed to customer satisfaction. This policy outlines the circumstances under which refunds may be available for our vehicle export services.</p>

<h2>2. Refund Eligibility</h2>

<h3>2.1 Pre-Purchase Phase</h3>
<p>If you cancel your order before we have purchased the vehicle:</p>
<ul>
<li><strong>Full Refund:</strong> Available minus 5% administrative processing fee</li>
<li><strong>Processing Time:</strong> 5-10 business days</li>
<li><strong>Method:</strong> Original payment method</li>
</ul>

<h3>2.2 Post-Purchase, Pre-Shipment</h3>
<p>If you cancel after vehicle purchase but before shipment:</p>
<ul>
<li><strong>Partial Refund:</strong> Purchase amount minus actual costs incurred</li>
<li><strong>Deductible Costs:</strong> Vehicle purchase price, inspection fees, storage costs</li>
<li><strong>Resale Proceeds:</strong> Any resale proceeds will be credited to your refund</li>
</ul>

<h3>2.3 Post-Shipment</h3>
<p>Once the vehicle has been shipped:</p>
<ul>
<li><strong>No Refunds:</strong> Generally not available</li>
<li><strong>Exceptions:</strong> Documented fraud or material misrepresentation</li>
<li><strong>Alternative:</strong> We will work to resolve issues through other means</li>
</ul>

<h2>3. Force Majeure Situations</h2>
<p>In cases of force majeure events that prevent service completion:</p>
<ul>
<li><strong>Pro-rata Refund:</strong> For undelivered services</li>
<li><strong>Service Credit:</strong> Option to apply credit to future orders</li>
<li><strong>Assessment Period:</strong> 30 days to evaluate situation</li>
</ul>

<h2>4. Vehicle Condition Disputes</h2>
<p>If the delivered vehicle does not match agreed specifications:</p>
<ul>
<li><strong>Documentation Required:</strong> Independent inspection report</li>
<li><strong>Claim Period:</strong> Must be filed within 7 days of delivery</li>
<li><strong>Resolution Options:</strong> Repair, replacement, or partial refund</li>
<li><strong>Dispute Process:</strong> Professional arbitration if needed</li>
</ul>

<h2>5. Non-Refundable Services</h2>
<p>The following services are non-refundable:</p>
<ul>
<li>Completed vehicle inspections</li>
<li>Documentation preparation fees</li>
<li>Customs clearance services</li>
<li>Shipping costs (unless service failure)</li>
<li>Third-party service fees</li>
</ul>

<h2>6. Refund Process</h2>

<h3>6.1 How to Request a Refund</h3>
<ol>
<li>Contact our customer service team</li>
<li>Provide order number and reason for refund</li>
<li>Submit required documentation</li>
<li>Allow 3-5 business days for review</li>
</ol>

<h3>6.2 Processing Timeline</h3>
<ul>
<li><strong>Review Period:</strong> 3-5 business days</li>
<li><strong>Approval Notification:</strong> Within 24 hours of decision</li>
<li><strong>Refund Processing:</strong> 5-10 business days to original payment method</li>
<li><strong>Bank Processing:</strong> Additional 2-5 business days</li>
</ul>

<h2>7. Partial Refunds</h2>
<p>Partial refunds may be offered in cases of:</p>
<ul>
<li>Minor vehicle condition discrepancies</li>
<li>Delivery delays beyond our control</li>
<li>Service modifications requested by customer</li>
<li>Compromise agreements to resolve disputes</li>
</ul>

<h2>8. Warranty vs. Refund</h2>
<p>Some issues may be covered by manufacturer or dealer warranties rather than refunds:</p>
<ul>
<li>Mechanical problems discovered post-delivery</li>
<li>Factory recalls or service bulletins</li>
<li>Normal wear and tear items</li>
</ul>

<h2>9. Customer Responsibilities</h2>
<p>To be eligible for refunds, customers must:</p>
<ul>
<li>Provide timely notification of issues</li>
<li>Allow reasonable inspection access</li>
<li>Maintain vehicle in delivered condition</li>
<li>Cooperate with resolution efforts</li>
</ul>

<h2>10. Contact for Refunds</h2>
<p>To request a refund or discuss refund eligibility:</p>
<ul>
<li><strong>Email:</strong> refunds@elitecarexport.com</li>
<li><strong>Phone:</strong> +49 123 456 7890</li>
<li><strong>Business Hours:</strong> Monday-Friday, 9 AM - 6 PM CET</li>
<li><strong>Address:</strong> Elite Car Export GmbH, Musterstraße 123, 12345 Berlin, Germany</li>
</ul>';
    }

    private function getRefundPolicyAr(): string
    {
        return '<h1>سياسة الاسترداد</h1>

<p><strong>تاريخ السريان:</strong> ' . now()->format('F j, Y') . '</p>

<h2>1. سياسة الاسترداد العامة</h2>
<p>شركة تصدير السيارات النخبة ملتزمة برضا العملاء. تحدد هذه السياسة الظروف التي قد تكون فيها المردودات متاحة لخدمات تصدير المركبات لدينا.</p>

<h2>2. أهلية الاسترداد</h2>

<h3>2.1 مرحلة ما قبل الشراء</h3>
<p>إذا ألغيت طلبك قبل أن نشتري المركبة:</p>
<ul>
<li><strong>استرداد كامل:</strong> متاح ناقص 5% رسوم معالجة إدارية</li>
<li><strong>وقت المعالجة:</strong> 5-10 أيام عمل</li>
<li><strong>الطريقة:</strong> طريقة الدفع الأصلية</li>
</ul>

<h3>2.2 ما بعد الشراء، قبل الشحن</h3>
<p>إذا ألغيت بعد شراء المركبة ولكن قبل الشحن:</p>
<ul>
<li><strong>استرداد جزئي:</strong> مبلغ الشراء ناقص التكاليف الفعلية المتكبدة</li>
<li><strong>التكاليف القابلة للخصم:</strong> سعر شراء المركبة، رسوم التفتيش، تكاليف التخزين</li>
<li><strong>عائدات إعادة البيع:</strong> أي عائدات إعادة بيع ستُضاف إلى استردادك</li>
</ul>

<h3>2.3 ما بعد الشحن</h3>
<p>بمجرد شحن المركبة:</p>
<ul>
<li><strong>لا مردودات:</strong> عموماً غير متاحة</li>
<li><strong>الاستثناءات:</strong> الاحتيال الموثق أو التحريف المادي</li>
<li><strong>البديل:</strong> سنعمل على حل المشاكل بوسائل أخرى</li>
</ul>

<h2>3. حالات القوة القاهرة</h2>
<p>في حالات أحداث القوة القاهرة التي تمنع إتمام الخدمة:</p>
<ul>
<li><strong>استرداد تناسبي:</strong> للخدمات غير المسلمة</li>
<li><strong>رصيد الخدمة:</strong> خيار تطبيق الرصيد على الطلبات المستقبلية</li>
<li><strong>فترة التقييم:</strong> 30 يوماً لتقييم الوضع</li>
</ul>

<h2>4. نزاعات حالة المركبة</h2>
<p>إذا لم تطابق المركبة المسلمة المواصفات المتفق عليها:</p>
<ul>
<li><strong>الوثائق المطلوبة:</strong> تقرير فحص مستقل</li>
<li><strong>فترة المطالبة:</strong> يجب تقديمها خلال 7 أيام من التسليم</li>
<li><strong>خيارات الحل:</strong> الإصلاح أو الاستبدال أو الاسترداد الجزئي</li>
<li><strong>عملية النزاع:</strong> التحكيم المهني إذا لزم الأمر</li>
</ul>

<h2>5. الخدمات غير القابلة للاسترداد</h2>
<p>الخدمات التالية غير قابلة للاسترداد:</p>
<ul>
<li>فحوصات المركبات المكتملة</li>
<li>رسوم إعداد الوثائق</li>
<li>خدمات تخليص الجمارك</li>
<li>تكاليف الشحن (إلا في حالة فشل الخدمة)</li>
<li>رسوم خدمات الطرف الثالث</li>
</ul>

<h2>6. عملية الاسترداد</h2>

<h3>6.1 كيفية طلب الاسترداد</h3>
<ol>
<li>اتصل بفريق خدمة العملاء لدينا</li>
<li>قدم رقم الطلب وسبب الاسترداد</li>
<li>أرسل الوثائق المطلوبة</li>
<li>اسمح بـ 3-5 أيام عمل للمراجعة</li>
</ol>

<h3>6.2 الجدول الزمني للمعالجة</h3>
<ul>
<li><strong>فترة المراجعة:</strong> 3-5 أيام عمل</li>
<li><strong>إشعار الموافقة:</strong> خلال 24 ساعة من القرار</li>
<li><strong>معالجة الاسترداد:</strong> 5-10 أيام عمل إلى طريقة الدفع الأصلية</li>
<li><strong>معالجة البنك:</strong> 2-5 أيام عمل إضافية</li>
</ul>

<h2>7. المردودات الجزئية</h2>
<p>قد تُعرض المردودات الجزئية في حالات:</p>
<ul>
<li>تناقضات طفيفة في حالة المركبة</li>
<li>تأخيرات التسليم خارج سيطرتنا</li>
<li>تعديلات الخدمة المطلوبة من العميل</li>
<li>اتفاقيات التسوية لحل النزاعات</li>
</ul>

<h2>8. الضمان مقابل الاسترداد</h2>
<p>قد تُغطى بعض المشاكل بضمانات الشركة المصنعة أو الوكيل بدلاً من المردودات:</p>
<ul>
<li>المشاكل الميكانيكية المكتشفة بعد التسليم</li>
<li>استدعاءات المصنع أو نشرات الخدمة</li>
<li>عناصر التآكل العادي</li>
</ul>

<h2>9. مسؤوليات العميل</h2>
<p>لتكون مؤهلاً للمردودات، يجب على العملاء:</p>
<ul>
<li>تقديم إشعار في الوقت المناسب بالمشاكل</li>
<li>السماح بوصول معقول للفحص</li>
<li>الحفاظ على المركبة في حالة التسليم</li>
<li>التعاون مع جهود الحل</li>
</ul>

<h2>10. الاتصال للمردودات</h2>
<p>لطلب استرداد أو مناقشة أهلية الاسترداد:</p>
<ul>
<li><strong>البريد الإلكتروني:</strong> refunds@elitecarexport.com</li>
<li><strong>الهاتف:</strong> +49 123 456 7890</li>
<li><strong>ساعات العمل:</strong> الاثنين-الجمعة، 9 صباحاً - 6 مساءً بتوقيت أوروبا الوسطى</li>
<li><strong>العنوان:</strong> Elite Car Export GmbH, Musterstraße 123, 12345 Berlin, Germany</li>
</ul>';
    }

    private function getShippingPolicyEn(): string
    {
        return '<h1>Shipping Policy</h1>

<p><strong>Effective Date:</strong> ' . now()->format('F j, Y') . '</p>

<h2>1. Shipping Overview</h2>
<p>Elite Car Export provides comprehensive vehicle shipping services from European ports to destinations worldwide. This policy outlines our shipping procedures, timelines, and responsibilities.</p>

<h2>2. Shipping Methods</h2>

<h3>2.1 Container Shipping (Recommended)</h3>
<ul>
<li><strong>Protection:</strong> Vehicle enclosed in 20ft or 40ft container</li>
<li><strong>Security:</strong> Maximum protection from weather and handling</li>
<li><strong>Capacity:</strong> 1-4 vehicles depending on size</li>
<li><strong>Transit Time:</strong> 14-35 days depending on destination</li>
</ul>

<h3>2.2 Roll-on/Roll-off (RoRo)</h3>
<ul>
<li><strong>Cost-Effective:</strong> Lower shipping costs</li>
<li><strong>Exposure:</strong> Vehicle exposed to weather during transit</li>
<li><strong>Restrictions:</strong> Fuel tank must be nearly empty</li>
<li><strong>Transit Time:</strong> 7-21 days depending on destination</li>
</ul>

<h2>3. Shipping Destinations</h2>

<h3>3.1 Regular Routes</h3>
<p>We provide regular shipping services to:</p>
<ul>
<li><strong>Middle East:</strong> UAE, Saudi Arabia, Kuwait, Qatar</li>
<li><strong>Africa:</strong> Nigeria, Ghana, Kenya, South Africa</li>
<li><strong>North America:</strong> USA, Canada, Mexico</li>
<li><strong>Asia:</strong> China, Japan, Singapore, Malaysia</li>
</ul>

<h3>3.2 Special Destinations</h3>
<p>For other destinations, we can arrange special shipping with additional lead time and costs.</p>

<h2>4. Shipping Timeline</h2>

<h3>4.1 Pre-Shipping Preparation</h3>
<ul>
<li><strong>Vehicle Preparation:</strong> 2-3 days</li>
<li><strong>Documentation:</strong> 3-5 days</li>
<li><strong>Port Delivery:</strong> 1-2 days</li>
<li><strong>Customs Clearance:</strong> 1-3 days</li>
</ul>

<h3>4.2 Transit Times by Region</h3>
<ul>
<li><strong>Middle East:</strong> 10-18 days</li>
<li><strong>West Africa:</strong> 12-20 days</li>
<li><strong>East Africa:</strong> 18-25 days</li>
<li><strong>North America:</strong> 14-21 days</li>
<li><strong>Asia:</strong> 20-35 days</li>
</ul>

<h2>5. Shipping Costs</h2>

<h3>5.1 Cost Components</h3>
<ul>
<li><strong>Freight Charges:</strong> Based on destination and method</li>
<li><strong>Port Handling:</strong> Loading/unloading fees</li>
<li><strong>Documentation:</strong> Bill of lading, certificates</li>
<li><strong>Insurance:</strong> Marine cargo insurance (recommended)</li>
</ul>

<h3>5.2 Payment Terms</h3>
<ul>
<li><strong>Advance Payment:</strong> 100% before shipment</li>
<li><strong>Payment Methods:</strong> Bank transfer, letter of credit</li>
<li><strong>Currency:</strong> EUR or USD</li>
</ul>

<h2>6. Documentation Required</h2>

<h3>6.1 Export Documents</h3>
<ul>
<li>Original vehicle title/registration</li>
<li>Purchase invoice</li>
<li>Export declaration</li>
<li>Certificate of compliance</li>
</ul>

<h3>6.2 Shipping Documents</h3>
<ul>
<li>Bill of lading</li>
<li>Packing list</li>
<li>Marine insurance certificate</li>
<li>Certificate of origin</li>
</ul>

<h2>7. Insurance Coverage</h2>

<h3>7.1 Marine Insurance</h3>
<ul>
<li><strong>Coverage:</strong> Total loss, general average, salvage charges</li>
<li><strong>Premium:</strong> 0.3-0.8% of vehicle value</li>
<li><strong>Claim Process:</strong> Direct with insurance company</li>
</ul>

<h3>7.2 Recommended Coverage</h3>
<ul>
<li>All risks marine insurance</li>
<li>War risks (if applicable)</li>
<li>Strikes, riots, civil commotions</li>
</ul>

<h2>8. Customer Responsibilities</h2>

<h3>8.1 Pre-Shipping</h3>
<ul>
<li>Provide accurate shipping instructions</li>
<li>Arrange destination country import permits</li>
<li>Designate customs clearing agent</li>
<li>Arrange final payment before shipment</li>
</ul>

<h3>8.2 At Destination</h3>
<ul>
<li>Clear customs within free storage period</li>
<li>Pay applicable duties and taxes</li>
<li>Arrange pickup from destination port</li>
<li>Complete local registration requirements</li>
</ul>

<h2>9. Delays and Force Majeure</h2>

<h3>9.1 Potential Delays</h3>
<ul>
<li>Weather conditions</li>
<li>Port congestion</li>
<li>Customs inspections</li>
<li>Documentation issues</li>
</ul>

<h3>9.2 Force Majeure Events</h3>
<p>We are not liable for delays caused by:</p>
<ul>
<li>Natural disasters</li>
<li>War or terrorism</li>
<li>Government actions</li>
<li>Labor strikes</li>
</ul>

<h2>10. Tracking and Communication</h2>
<ul>
<li><strong>Departure Notification:</strong> Within 24 hours of sailing</li>
<li><strong>Tracking Updates:</strong> Weekly status reports</li>
<li><strong>Arrival Notification:</strong> 48 hours before arrival</li>
<li><strong>Customer Portal:</strong> Online tracking available</li>
</ul>

<h2>11. Contact Information</h2>
<p>For shipping inquiries and updates:</p>
<ul>
<li><strong>Email:</strong> shipping@elitecarexport.com</li>
<li><strong>Phone:</strong> +49 123 456 7890</li>
<li><strong>Emergency:</strong> +49 123 456 7891 (24/7)</li>
<li><strong>Address:</strong> Elite Car Export GmbH, Musterstraße 123, 12345 Berlin, Germany</li>
</ul>';
    }

    private function getShippingPolicyAr(): string
    {
        return '<h1>سياسة الشحن</h1>

<p><strong>تاريخ السريان:</strong> ' . now()->format('F j, Y') . '</p>

<h2>1. نظرة عامة على الشحن</h2>
<p>تقدم شركة تصدير السيارات النخبة خدمات شحن المركبات الشاملة من الموانئ الأوروبية إلى وجهات حول العالم. تحدد هذه السياسة إجراءات الشحن والجداول الزمنية والمسؤوليات.</p>

<h2>2. طرق الشحن</h2>

<h3>2.1 الشحن بالحاوية (موصى به)</h3>
<ul>
<li><strong>الحماية:</strong> المركبة محاطة في حاوية 20 أو 40 قدم</li>
<li><strong>الأمان:</strong> أقصى حماية من الطقس والتعامل</li>
<li><strong>السعة:</strong> 1-4 مركبات حسب الحجم</li>
<li><strong>وقت النقل:</strong> 14-35 يوماً حسب الوجهة</li>
</ul>

<h3>2.2 الشحن المتدحرج (RoRo)</h3>
<ul>
<li><strong>فعال من ناحية التكلفة:</strong> تكاليف شحن أقل</li>
<li><strong>التعرض:</strong> المركبة معرضة للطقس أثناء النقل</li>
<li><strong>القيود:</strong> يجب أن يكون خزان الوقود فارغاً تقريباً</li>
<li><strong>وقت النقل:</strong> 7-21 يوماً حسب الوجهة</li>
</ul>

<h2>3. وجهات الشحن</h2>

<h3>3.1 الطرق المنتظمة</h3>
<p>نقدم خدمات شحن منتظمة إلى:</p>
<ul>
<li><strong>الشرق الأوسط:</strong> الإمارات، السعودية، الكويت، قطر</li>
<li><strong>أفريقيا:</strong> نيجيريا، غانا، كينيا، جنوب أفريقيا</li>
<li><strong>أمريكا الشمالية:</strong> الولايات المتحدة، كندا، المكسيك</li>
<li><strong>آسيا:</strong> الصين، اليابان، سنغافورة، ماليزيا</li>
</ul>

<h3>3.2 الوجهات الخاصة</h3>
<p>للوجهات الأخرى، يمكننا ترتيب شحن خاص بوقت إضافي وتكاليف.</p>

<h2>4. الجدول الزمني للشحن</h2>

<h3>4.1 التحضير قبل الشحن</h3>
<ul>
<li><strong>إعداد المركبة:</strong> 2-3 أيام</li>
<li><strong>الوثائق:</strong> 3-5 أيام</li>
<li><strong>التسليم للميناء:</strong> 1-2 يوم</li>
<li><strong>تخليص الجمارك:</strong> 1-3 أيام</li>
</ul>

<h3>4.2 أوقات النقل حسب المنطقة</h3>
<ul>
<li><strong>الشرق الأوسط:</strong> 10-18 يوماً</li>
<li><strong>غرب أفريقيا:</strong> 12-20 يوماً</li>
<li><strong>شرق أفريقيا:</strong> 18-25 يوماً</li>
<li><strong>أمريكا الشمالية:</strong> 14-21 يوماً</li>
<li><strong>آسيا:</strong> 20-35 يوماً</li>
</ul>

<h2>5. تكاليف الشحن</h2>

<h3>5.1 مكونات التكلفة</h3>
<ul>
<li><strong>رسوم الشحن:</strong> على أساس الوجهة والطريقة</li>
<li><strong>معالجة الميناء:</strong> رسوم التحميل/التفريغ</li>
<li><strong>الوثائق:</strong> بوليصة الشحن، الشهادات</li>
<li><strong>التأمين:</strong> تأمين البضائع البحرية (موصى به)</li>
</ul>

<h3>5.2 شروط الدفع</h3>
<ul>
<li><strong>الدفع المقدم:</strong> 100% قبل الشحن</li>
<li><strong>طرق الدفع:</strong> تحويل مصرفي، خطاب اعتماد</li>
<li><strong>العملة:</strong> اليورو أو الدولار الأمريكي</li>
</ul>

<h2>6. الوثائق المطلوبة</h2>

<h3>6.1 وثائق التصدير</h3>
<ul>
<li>سند ملكية/تسجيل المركبة الأصلي</li>
<li>فاتورة الشراء</li>
<li>إعلان التصدير</li>
<li>شهادة المطابقة</li>
</ul>

<h3>6.2 وثائق الشحن</h3>
<ul>
<li>بوليصة الشحن</li>
<li>قائمة التعبئة</li>
<li>شهادة التأمين البحري</li>
<li>شهادة المنشأ</li>
</ul>

<h2>7. التغطية التأمينية</h2>

<h3>7.1 التأمين البحري</h3>
<ul>
<li><strong>التغطية:</strong> الخسارة الكلية، المتوسط العام، رسوم الإنقاذ</li>
<li><strong>القسط:</strong> 0.3-0.8% من قيمة المركبة</li>
<li><strong>عملية المطالبة:</strong> مباشرة مع شركة التأمين</li>
</ul>

<h3>7.2 التغطية الموصى بها</h3>
<ul>
<li>تأمين بحري ضد جميع المخاطر</li>
<li>مخاطر الحرب (إذا كان قابلاً للتطبيق)</li>
<li>الإضرابات والشغب والاضطرابات المدنية</li>
</ul>

<h2>8. مسؤوليات العميل</h2>

<h3>8.1 قبل الشحن</h3>
<ul>
<li>تقديم تعليمات شحن دقيقة</li>
<li>ترتيب تصاريح الاستيراد لبلد الوجهة</li>
<li>تعيين وكيل تخليص الجمارك</li>
<li>ترتيب الدفع النهائي قبل الشحن</li>
</ul>

<h3>8.2 في الوجهة</h3>
<ul>
<li>تخليص الجمارك خلال فترة التخزين المجانية</li>
<li>دفع الرسوم والضرائب المعمول بها</li>
<li>ترتيب الاستلام من ميناء الوجهة</li>
<li>إكمال متطلبات التسجيل المحلية</li>
</ul>

<h2>9. التأخيرات والقوة القاهرة</h2>

<h3>9.1 التأخيرات المحتملة</h3>
<ul>
<li>الظروف الجوية</li>
<li>ازدحام الميناء</li>
<li>فحوصات الجمارك</li>
<li>مشاكل الوثائق</li>
</ul>

<h3>9.2 أحداث القوة القاهرة</h3>
<p>لسنا مسؤولين عن التأخيرات الناجمة عن:</p>
<ul>
<li>الكوارث الطبيعية</li>
<li>الحرب أو الإرهاب</li>
<li>الإجراءات الحكومية</li>
<li>إضرابات العمال</li>
</ul>

<h2>10. التتبع والتواصل</h2>
<ul>
<li><strong>إشعار المغادرة:</strong> خلال 24 ساعة من الإبحار</li>
<li><strong>تحديثات التتبع:</strong> تقارير حالة أسبوعية</li>
<li><strong>إشعار الوصول:</strong> 48 ساعة قبل الوصول</li>
<li><strong>بوابة العملاء:</strong> التتبع عبر الإنترنت متاح</li>
</ul>

<h2>11. معلومات الاتصال</h2>
<p>للاستفسارات والتحديثات حول الشحن:</p>
<ul>
<li><strong>البريد الإلكتروني:</strong> shipping@elitecarexport.com</li>
<li><strong>الهاتف:</strong> +49 123 456 7890</li>
<li><strong>الطوارئ:</strong> +49 123 456 7891 (24/7)</li>
<li><strong>العنوان:</strong> Elite Car Export GmbH, Musterstraße 123, 12345 Berlin, Germany</li>
</ul>';
    }
}