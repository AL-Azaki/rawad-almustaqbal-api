<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectCaseStudiesSeeder extends Seeder
{
    public function run(): void
    {
        $caseStudies = [
            [
                'slug' => 'smart-home-villa-al-marjan',
                'title' => 'مشروع أتمتة وحلول تحكم مركزي (Smart Home & KNX) لفيلا خاصة',
                'category' => 'منازل ذكية',
                'location_district' => 'حي المرجان، أبحر الشمالية، جدة',
                'duration' => '3 أسابيع عمل ميداني + أسبوع برمجة واختبار',
                'description' => 'تنفيذ بنية تحتية ذكية متكاملة لفيلا حديثة البناء في حي المرجان بشمال جدة، تشمل أتمتة الإضاءة المعمارية، الستائر الكهربائية، التكييف المركزي، وأنظمة الصوتيات، مع لوحة تحكم مركزية موحدة وتطبيق ذكي باللغتين العربية والإنجليزية، وفق أعلى معايير الأمان وموثوقية التشغيل.',
                'challenge_solution_text' => "### التحدي الفني والوضع السابق للموقع:\nكان العقار يعاني من تعقيد شديد في تمديدات الكهرباء التقليدية والدوائر المتداخلة، مع وجود أكثر من 45 نقطة إضاءة مستقلة و8 وحدات تكييف مخفي (Concealed AC) تتطلب لوحات تحكم منفصلة وتمديدات أسلاك غير منظمة في الأسقف المستعارة. كما واجه المالك مشكلة ضعف تغطية الإشارة اللاسلكية بين الطوابق الثلاثة والملحق الخارجي بسبب سماكة الجدران الخرسانية والعوازل الحرارية الحديثة في بناء فلل شمال جدة.\n\n### الحل الهندسي المنفذ ومنهجية العمل:\n1. **إعادة هندسة التمديدات الكهربائية:** قام فريق مهندسي \"رواد المستقبل\" بتصميم مخطط أحادي الخط (Single Line Diagram) وفصل أحمال الإنارة عن القوى، وتأسيس شبكة نواقل كابلات KNX و Cat6A محمية داخل مواسير EMT غير قابلة للاشتعال.\n2. **التحكم الذكي والبرمجة:** تم تركيب مشغلات (Actuators) ذكية في لوحة التوزيع الرئيسية (Main DB) لتوحيد التحكم في الإضاءة التعتيمية (Dimmers) والتكييف المركزي والستائر.\n3. **البنية التحتية للشبكة:** نشر نظام شبكات Wi-Fi 6 Mesh مدعوم بمبدلات (PoE+ Switches) وكابلات ألياف ضوئية داخلية لضمان استقرار استجابة الأوامر الذكية بنسبة 100% دون أي تأخير (Zero Latency).",
                'installed_equipment' => [
                    ['ar' => 'وحدة تحكم مركزية للأنظمة الذكية (Smart Gateway Pro with Local Processing)', 'en' => 'Smart Gateway Pro with Local Processing'],
                    ['ar' => 'مبدل شبكة رئيسي 24 منفذ منافذ طاقة (24-Port Gigabit PoE+ Managed Switch)', 'en' => '24-Port Gigabit PoE+ Managed Switch'],
                    ['ar' => 'مشغلات إضاءة وتعتيم ذكية 16 قناة (16-Channel Smart Lighting & Dimming Actuators)', 'en' => '16-Channel Smart Lighting & Dimming Actuators'],
                    ['ar' => 'نقاط وصول لاسلكية داخلية وخارجية (Wi-Fi 6 AX3000 Ceiling/Wall Access Points)', 'en' => 'Wi-Fi 6 AX3000 Ceiling/Wall Access Points'],
                    ['ar' => 'محركات ستائر صامتة فائقة التحمل (Ultra-Quiet Smart Curtain Motors & Tracks)', 'en' => 'Ultra-Quiet Smart Curtain Motors & Tracks'],
                    ['ar' => 'كابلات شبكات نحاسية معزولة (Cat6A Shielded S/FTP Pure Copper Cabling)', 'en' => 'Cat6A Shielded S/FTP Pure Copper Cabling'],
                ],
                'image_path' => 'https://images.unsplash.com/photo-1558036117-15d82a90b9b1?auto=format&fit=crop&q=80&w=1200',
                'before_image_path' => 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?auto=format&fit=crop&q=80&w=800',
                'after_image_path' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'slug' => 'fiber-network-cctv-al-shiraa',
                'title' => 'بنية ألياف ضوئية وكاميرات مراقبة 4K ومقوي شبكة لفيلا سكنية',
                'category' => 'كاميرات مراقبة',
                'location_district' => 'حي الشراع، أبحر الشمالية، جدة',
                'duration' => '10 أيام عمل ميداني متواصل',
                'description' => 'تأسيس شبكة ألياف ضوئية داخلية (Fiber Optics) فائقة السرعة مع ربط كاميرات مراقبة IP بدقة 4K للمحيط الخارجي والمداخل الرئيسية لفيلا حديثة في حي الشراع، مع معالجة شاملة لضعف إشارة الإنترنت وعزل الأسلاك في كابينة مخصصة مجهزة بأنظمة حماية من انقطاع التيار.',
                'challenge_solution_text' => "### التحدي الفني والوضع السابق للموقع:\nكانت الفيلا تعاني من انقطاع متكرر للإنترنت وبطء شديد في كاميرات المراقبة القديمة التناظرية (Analog CCTV)، بالإضافة إلى تشوه بصري حاد بسبب الأسلاك الممتدة عشوائياً على الجدران الخارجية وتداخل كابلات الكهرباء مع كابلات الداتا، مما سبب تشويشاً مغناطيسياً وفقداناً للإشارة في الطابق العلوي.\n\n### الحل الهندسي المنفذ ومنهجية العمل:\n1. **إزالة وتحديث البنية التحتية:** تم سحب كافة التمديدات القديمة وتنظيف المسارات المخفية داخل الجدران وتمديد كابلات ألياف ضوئية وكابلات Cat6A معزولة للحد من التشويش الكهرومغناطيسي.\n2. **نظام المراقبة الذكي:** تركيب 12 كاميرا IP دقة 8 ميجابكسل (4K Ultra HD) مزودة بتقنية الرؤية الليلية الملونة (ColorVu) والذكاء الاصطناعي لتمييز الأشخاص والمركبات وتقليل التنبيهات الكاذبة.\n3. **كابينة الشبكة الرئيسية:** تجهيز كابينة Wall-Mount Rack مقاس 15U تحتوي على Patch Panels مرتبة ومؤرضة هندسياً، مع وحدة تزويد طاقة غير منقطعة (UPS 2000VA) تضمن استمرار عمل الكاميرات والإنترنت لمدة 4 ساعات عند انقطاع الكهرباء.",
                'installed_equipment' => [
                    ['ar' => 'جهاز تسجيل شبكي 16 منفذ يدعم 4K (16-Channel 4K NVR with 8TB Surveillance HDD)', 'en' => '16-Channel 4K NVR with 8TB Surveillance HDD'],
                    ['ar' => 'كاميرات مراقبة شبكية خارجية وداخلية (8MP 4K ColorVu IP Cameras with AI Detection)', 'en' => '8MP 4K ColorVu IP Cameras with AI Detection'],
                    ['ar' => 'مبدل شبكة طاقة عالية (16-Port Gigabit PoE+ Switch with Fiber SFP Uplinks)', 'en' => '16-Port Gigabit PoE+ Switch with Fiber SFP Uplinks'],
                    ['ar' => 'نقاط وصول لاسلكية عالية السرعة (Wi-Fi 6 Dual-Band Mesh Access Points)', 'en' => 'Wi-Fi 6 Dual-Band Mesh Access Points'],
                    ['ar' => 'وحدة طاقة احتياطية طوارئ (2000VA Smart UPS Battery Backup Power Supply)', 'en' => '2000VA Smart UPS Battery Backup Power Supply'],
                    ['ar' => 'كابينة شبكات جدارية منظمة (15U Wall-Mount Network Cabinet with Cable Organizers)', 'en' => '15U Wall-Mount Network Cabinet with Cable Organizers'],
                ],
                'image_path' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&q=80&w=1200',
                'before_image_path' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&q=80&w=800',
                'after_image_path' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'slug' => 'electrical-wiring-panel-al-yaqout',
                'title' => 'إعادة تأسيس التمديدات الكهربائية وترتيب الطبلونات الرئيسية',
                'category' => 'كهرباء',
                'location_district' => 'حي الياقوت، أبحر الشمالية، جدة',
                'duration' => '14 يوم عمل ميداني واختبار أحمال',
                'description' => 'مشروع إعادة تأهيل وتوزيع أحمال كهربائية متكامل لفيلا سكنية في حي الياقوت، شمل معالجة هبوط الجهد (Voltage Drop) وتغيير اللوحات الرئيسية والفرعية وفق الكود السعودي للبناء (SBC 401)، مع تركيب قواطع حماية من الالتماس والشرار الكهربائي لضمان السلامة القصوى للعائلة.',
                'challenge_solution_text' => "### التحدي الفني والوضع السابق للموقع:\nواجه المالك انقطاعات متكررة واحتراقاً في بعض المقابس الكهربائية عند تشغيل أجهزة التكييف وسخانات المياه في آن واحد، إضافة إلى ارتفاع غير مبرر في فاتورة الكهرباء. عند الفحص الميداني الدقيق بأجهزة القياس الحرارية (Thermal Cameras)، تبين وجود أحمال زائدة غير موزعة بشكل متوازن بين الفازات الثلاث (Three-Phase Imbalance)، واستخدام أسلاك تجارية غير مطابقة للمواصفات السعودية في التأسيس السابق.\n\n### الحل الهندسي المنفذ ومنهجية العمل:\n1. **التحليل الحراري وتوزيع الأحمال:** إجراء مسح حراري لكافة الطبلونات وسحب الأسلاك التالفة واستبدالها بأسلاك نحاسية معتمدة ذات عزل حراري عالٍ (THHN/THWN).\n2. **تحديث اللوحات الكهربائية:** تركيب لوحة توزيع رئيسية (Main Distribution Board) جديدة مع قواطع حماية تفاضلية (RCBO/ELCB) للحماية الصارمة من التسريب الأرضي والصدمات الكهربائية.\n3. **نظام الحماية من الصواعق والجهد الزائد:** تركيب أجهزة حماية ضد ارتفاع الجهد المفاجئ (Surge Protection Devices - SPD) لحماية الأجهزة المنزلية الحساسة والشاشات الذكية.",
                'installed_equipment' => [
                    ['ar' => 'لوحات توزيع كهربائية رئيسية وفرعية (Main & Sub Distribution Panels - Schneider/ABB)', 'en' => 'Main & Sub Distribution Panels - Schneider/ABB'],
                    ['ar' => 'قواطع حماية تفاضلية ضد التسريب الأرضي (30mA RCBO/RCCB Earth Leakage Circuit Breakers)', 'en' => '30mA RCBO/RCCB Earth Leakage Circuit Breakers'],
                    ['ar' => 'أجهزة حماية من ارتفاع الجهد المفاجئ (Type 2 Surge Protection Devices - SPD)', 'en' => 'Type 2 Surge Protection Devices - SPD'],
                    ['ar' => 'أسلاك وكابلات نحاسية معتمدة (Saudi Made Pure Copper Wires THHN 4mm/6mm/10mm)', 'en' => 'Saudi Made Pure Copper Wires THHN 4mm/6mm/10mm'],
                    ['ar' => 'قضبان ونظام تأريض متكامل (Pure Copper Grounding Rods and Equipotential Bonding)', 'en' => 'Pure Copper Grounding Rods and Equipotential Bonding'],
                ],
                'image_path' => 'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?auto=format&fit=crop&q=80&w=1200',
                'before_image_path' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&q=80&w=800',
                'after_image_path' => 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'slug' => 'cctv-intercom-resort-obhur-corniche',
                'title' => 'نظام مراقبة أمنية محيطية وإنتركم مرئي IP لمنتجع شاطئي',
                'category' => 'أنظمة مراقبة',
                'location_district' => 'كورنيش أبحر الشمالية، جدة',
                'duration' => '4 أسابيع تنفيذ وتمديدات خارجية معزولة',
                'description' => 'تصميم وتنفيذ منظومة أمنية متكاملة لمنتجع وشاليهات خاصة على كورنيش أبحر الشمالية، تتضمن كاميرات مراقبة خارجية مقاومة للأملاح والرطوبة العالية، ونظام إنتركم مرئي ذكي متصل بالهواتف المحمولة للتحكم ببوابات الدخول عن بُعد، مع تغطية لاسلكية شاملة للمناطق المفتوحة والشاطئ.',
                'challenge_solution_text' => "### التحدي الفني والوضع السابق للموقع:\nطبيعة الموقع الساحلي المباشر على البحر المتوسط الرطوبة الشديدة والأبخرة الملحية، مما تسبب في تلف وتآكل الكاميرات السابقة والموزعات الخارجية خلال أشهر معدودة. كما أن مساحة المنتجع الممتدة (أكثر من 4,000 متر مربع) جعلت تمديد الأسلاك النحاسية العادية غير مجدٍ لتجاوزها المسافة القصوى لنقل البيانات (100 متر).\n\n### الحل الهندسي المنفذ ومنهجية العمل:\n1. **تمديدات ألياف ضوئية وبنية مقاومة للعوامل الجوية:** ربط النقاط البعيدة عبر كابلات ألياف ضوئية خارجية (Armored Outdoor Fiber) ممددة داخل غرف تفتيش ومواسير UPVC محكمة الغلق.\n2. **تجهيزات مقاومة للأملاح:** اختيار كاميرات مراقبة وأجهزة إنتركم بهيكل معدني مقاوم للصدأ بتصنيف حماية IP67 و IK10 ضد الصدمات والعوامل البحرية الشديدة.\n3. **الإنتركم وبوابات الدخول الذكية:** تركيب نظام إنتركم مرئي متعدد الوحدات يتيح للزوار الاتصال المباشر بجوال المالك أو المشرف وفتح البوابة بضغطة زر أو عبر رمز QR مؤقت للضيوف.",
                'installed_equipment' => [
                    ['ar' => 'كاميرات مراقبة بحرية مقاومة للأملاح (IP67 Weatherproof & Corrosion-Resistant 4K Cameras)', 'en' => 'IP67 Weatherproof & Corrosion-Resistant 4K Cameras'],
                    ['ar' => 'نظام إنتركم مرئي ذكي عبر بروتوكول IP (IP Video Intercom System with Mobile App Integration)', 'en' => 'IP Video Intercom System with Mobile App Integration'],
                    ['ar' => 'أقفال كهرومغناطيسية عالية التحمل (600lbs Magnetic Gate Locks & Remote Access Controllers)', 'en' => '600lbs Magnetic Gate Locks & Remote Access Controllers'],
                    ['ar' => 'كابلات ألياف ضوئية مسلحة خارجية (Armored Outdoor Single-Mode Fiber Optic Cabling)', 'en' => 'Armored Outdoor Single-Mode Fiber Optic Cabling'],
                    ['ar' => 'نقاط وصول لاسلكية خارجية مقاومة للماء (Long-Range Outdoor Weatherproof Wi-Fi 6 Access Points)', 'en' => 'Long-Range Outdoor Weatherproof Wi-Fi 6 Access Points'],
                ],
                'image_path' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&q=80&w=1200',
                'before_image_path' => 'https://images.unsplash.com/photo-1508873696983-2df529a3c882?auto=format&fit=crop&q=80&w=800',
                'after_image_path' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'slug' => 'datacenter-network-cabling-al-shati',
                'title' => 'تأسيس غرفة خوادم وتنظيم كابلات شبكات وحلول تغطية لقصر خاص',
                'category' => 'شبكات',
                'location_district' => 'حي الشاطئ، جدة',
                'duration' => '3 أسابيع عمل واختبار اعتماد Fluke',
                'description' => 'تنفيذ بنية شبكات مؤسسية متقدمة لقصر خاص في حي الشاطئ، تشمل تجهيز غرفة خوادم (Server Room) معزولة، وترتيب وتنظيم أكثر من 120 نقطة شبكة سلكية Cat6A S/FTP، مع اختبار واعتماد الكابلات بجهاز Fluke، وتركيب نظام تغطية Wi-Fi 6E مخفي ينسجم بالكامل مع الفخامة المعمارية للمكان.',
                'challenge_solution_text' => "### التحدي الفني والوضع السابق للموقع:\nكان القصر يحتوي على كابينة رئيسية شديدة العشوائية والاكتظاظ (Spaghetti Cabling)، حيث يصعب تحديد مسار أي كابل أو إجراء أي صيانة دون التسبب بقطع الخدمة عن كامل القصر. كما عانت غرف الاستقبال الرئيسية والقبو (Basement) من انعدام الإشارة التام بسبب الجدران الرخامية المزدوجة ونظم العزل الخرساني السميكة.\n\n### الحل الهندسي المنفذ ومنهجية العمل:\n1. **إعادة هيكلة غرفة الخوادم:** فك الكابينة القديمة بالكامل دون تعطيل الأنظمة الحرجة خلال ساعات الليل، وتركيب كابينة Floor-Standing Rack مقاس 42U مجهزة بنظم تهوية فعالة وإدارة كابلات عمودية وأفقية (Cable Managers).\n2. **الترقيم والفحص الهندسي:** ترقيم جميع نقاط الشبكة بنظام مطبوع (Labeling System) واختبار كل مسار سلكي بجهاز Fluke DSX-600 لضمان تحقيق سرعة نقل 10Gbps بدون أي فاقد.\n3. **التغطية اللاسلكية المخفية:** دمج نقاط وصول Wi-Fi 6E عالية القدرة داخل التجاويف الجبسية والديكورات الخشبية مع الحفاظ على إرسال قوي واستمرارية الاتصال السلس أثناء التنقل (Seamless Roaming).",
                'installed_equipment' => [
                    ['ar' => 'كابينة خوادم أرضية احترافية مقاس 42U (42U Server Rack Cabinet with Dual Cooling Fans & PDU)', 'en' => '42U Server Rack Cabinet with Dual Cooling Fans & PDU'],
                    ['ar' => 'لوحات تجميع وترقيم الكابلات 24 منفذ (24-Port Cat6A Shielded Patch Panels & Cable Organizers)', 'en' => '24-Port Cat6A Shielded Patch Panels & Cable Organizers'],
                    ['ar' => 'مبدلات شبكة مركزية عالية الأداء (48-Port Enterprise Managed Switches with 10G Uplink)', 'en' => '48-Port Enterprise Managed Switches with 10G Uplink'],
                    ['ar' => 'نقاط وصول واي فاي ثلاثية النطاق (Tri-Band Wi-Fi 6E Access Points with Seamless Roaming)', 'en' => 'Tri-Band Wi-Fi 6E Access Points with Seamless Roaming'],
                    ['ar' => 'كابلات وأسلاك شبكات معزولة بالكامل (Fluke Certified Cat6A S/FTP Shielded Solid Copper Cable)', 'en' => 'Fluke Certified Cat6A S/FTP Shielded Solid Copper Cable'],
                ],
                'image_path' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&q=80&w=1200',
                'before_image_path' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&q=80&w=800',
                'after_image_path' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'slug' => 'smart-lighting-automation-al-muhammadiyah',
                'title' => 'إضاءة معمارية مخفية وتحكم ذكي بالستائر والتكييف لفيلا فاخرة',
                'category' => 'ديكور وإنارة',
                'location_district' => 'حي المحمدية، جدة',
                'duration' => '18 يوم عمل ميداني وبرمجة مشاهد',
                'description' => 'تصميم وتنفيذ أنظمة الإضاءة المعمارية الذكية (Architectural Lighting Automation) وبرمجة المشاهد الضوئية (Lighting Scenes) لفيلا فاخرة في حي المحمدية، مع دمج مستشعرات الحركة والإنارة الطبيعية لترشيد استهلاك الطاقة، وربط كامل للمكيفات المخفية والستائر الكهربائية بنظام تحكم ذكي وسهل الاستخدام للعائلة والضيوف.',
                'challenge_solution_text' => "### التحدي الفني والوضع السابق للموقع:\nتضمنت الفيلا تصميمات ديكور معقدة جداً تحتوي على شرائط LED مخفية متعددة ومصابيح تركيز (Track Lights & Spotlights) تتطلب تحكماً دقيقاً في درجات السطوع ولون الإضاءة (Tunable White). استخدام المفاتيح الجدارية العادية كان سيتطلب صفوفاً طويلة ومشوهة من المفاتيح في كل غرفة، بالإضافة إلى صعوبة ضبط الإضاءة المناسبة لكل أوقات اليوم يدوياً.\n\n### الحل الهندسي المنفذ ومنهجية العمل:\n1. **استبدال المفاتيح التقليدية بشاشات ذكية:** استبدال صفوف المفاتيح العادية بشاشات لمس زجاجية أنيقة وأزرار ذكية قابلة للبرمجة (Programmable Keypads) تتحكم بجميع أنظمة الغرفة بضغطة واحدة.\n2. **برمجة المشاهد الضوئية حسب أوقات اليوم:** إنشاء سيناريوهات ذكية مخصصة مثل \"مشهد الاستقبال\"، \"مشهد الاسترخاء المسائي\"، و\"مشهد الخروج من المنزل\" الذي يطفئ كافة أضواء الفيلا ويفصل التكييف غير الضروري بلمسة واحدة.\n3. **التوافق التام مع المساعدات الصوتية:** دمج النظام مع Apple HomeKit و Amazon Alexa لتمكين المالك من التحكم الصوتي السريع والمراقبة الآنية لحالة الإضاءة والتكييف من أي مكان في العالم.",
                'installed_equipment' => [
                    ['ar' => 'وحدات تحكم إضاءة ذكية متعددة القنوات (Multi-Channel Smart Dimming Controllers & Relay Modules)', 'en' => 'Multi-Channel Smart Dimming Controllers & Relay Modules'],
                    ['ar' => 'مفاتيح وشاشات لمس زجاجية فاخرة (Glass Touch Keypads & Smart Thermostat Control Panels)', 'en' => 'Glass Touch Keypads & Smart Thermostat Control Panels'],
                    ['ar' => 'مستشعرات وجود وحركة وضوء طبيعي (Ceiling Mount Motion, Presence & Daylight Sensors)', 'en' => 'Ceiling Mount Motion, Presence & Daylight Sensors'],
                    ['ar' => 'محولات طاقة وكابلات إشارة معتمدة (MeanWell Dimmable Drivers and KNX Bus Cable)', 'en' => 'MeanWell Dimmable Drivers and KNX Bus Cable'],
                    ['ar' => 'بوابات ربط سحابي ومحلي آمنة (Cloud & Local Smart Home Automation Bridges)', 'en' => 'Cloud & Local Smart Home Automation Bridges'],
                ],
                'image_path' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80&w=1200',
                'before_image_path' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&q=80&w=800',
                'after_image_path' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80&w=800',
            ],
        ];

        foreach ($caseStudies as $cs) {
            Project::updateOrCreate(['slug' => $cs['slug']], $cs);
        }
    }
}
