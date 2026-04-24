import { motion } from 'framer-motion';
import { ShieldCheck } from 'lucide-react';

export default function Privacy() {
  const sections = [
    {
      title: '1. Цуглуулах мэдээлэл',
      body: 'Бид үйлчилгээгээ сайжруулах, хэрэглэгчийн туршлагыг илүү хувийн шинжтэй болгох зорилгоор заримдаа таны нэр, имэйл, хэрэглээний статистик мэдээллийг цуглуулж болно.',
    },
    {
      title: '2. Мэдээллийн хэрэглээ',
      body: 'Цугларсан мэдээллийг зөвхөн үйлчилгээний хүрээнд, хэрэглэгчийн зөвшөөрлийн үндсэн дээр ашиглана. Гуравдагч этгээдэд худалдахгүй.',
    },
    {
      title: '3. Cookies',
      body: 'Манай сайт хэрэглэгчийн тохиргоо хадгалах, трафик хэмжих зорилгоор cookies ашигладаг. Та хүссэн үедээ хөтчийн тохиргоогоор хориглох боломжтой.',
    },
    {
      title: '4. Гуравдагч үйлчилгээ',
      body: 'Бид Google Analytics, Facebook Pixel зэрэг анализын хэрэгслийг ашиглаж болох ба тэдгээрийн нууцлалын бодлогод тус тусдаа захирагдана.',
    },
    {
      title: '5. Аюулгүй байдал',
      body: 'Таны мэдээллийг зөвшөөрөлгүй нэвтрэлт, өөрчлөлт, алдагдлаас хамгаалах зорилгоор үндсэн болон нэмэлт техникийн арга хэмжээг авч ажилладаг.',
    },
    {
      title: '6. Өөрчлөлт',
      body: 'Энэхүү бодлого нь шаардлагын дагуу шинэчлэгдэж болно. Шинэчилсэн хувилбарыг энэ хуудсанд нийтэлнэ.',
    },
  ];

  return (
    <div className="max-w-3xl mx-auto px-4 py-12 lg:py-16">
      <motion.div
        initial={{ opacity: 0, y: 16 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.4 }}
      >
        <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-gradient text-white text-[11px] font-black uppercase tracking-[0.18em]">
          <ShieldCheck className="w-3.5 h-3.5" /> Нууцлалын бодлого
        </div>
        <h1 className="mt-4 text-4xl lg:text-5xl font-black leading-tight">
          Таны итгэл — <span className="bg-brand-gradient bg-clip-text text-transparent">бидний үүрэг</span>
        </h1>
        <p className="mt-4 text-muted-foreground">
          Сүүлд шинэчилсэн: 2026 оны 4 сарын 21
        </p>
      </motion.div>

      <div className="mt-10 space-y-6">
        {sections.map((s) => (
          <section key={s.title}>
            <h2 className="text-lg font-black">{s.title}</h2>
            <p className="mt-2 text-muted-foreground leading-relaxed">{s.body}</p>
          </section>
        ))}
      </div>

      <div className="mt-12 p-5 rounded-2xl border border-border bg-card text-sm text-muted-foreground">
        Асуулт байвал <a href="mailto:privacy@odod.mn" className="text-brand-pink font-semibold">privacy@odod.mn</a> хаягаар холбогдоно уу.
      </div>
    </div>
  );
}
