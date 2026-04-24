import { motion } from 'framer-motion';
import { Sparkles, Star, Users, TrendingUp } from 'lucide-react';

export default function About() {
  return (
    <div className="max-w-5xl mx-auto px-4 py-12 lg:py-16">
      <motion.div
        initial={{ opacity: 0, y: 16 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.4 }}
      >
        <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-gradient text-white text-[11px] font-black uppercase tracking-[0.18em]">
          <Sparkles className="w-3.5 h-3.5" /> Бидний тухай
        </div>
        <h1 className="mt-4 text-4xl lg:text-5xl font-black leading-tight">
          ODOD — Монголын оддын <span className="bg-brand-gradient bg-clip-text text-transparent">амьдрал</span>
        </h1>
        <p className="mt-5 text-lg text-muted-foreground max-w-3xl leading-relaxed">
          ODOD News бол одод, загвар, цуурхлыг хамгийн эхэнд хүргэдэг цахим хэвлэл юм.
          Бид олон нийтийн анхаарлыг татаж буй хамгийн халуун мэдээг баталгаатай эх сурвалжаас
          шуурхай танд хүргэхийг зорьдог.
        </p>
      </motion.div>

      <div className="grid sm:grid-cols-3 gap-4 mt-12">
        {[
          { icon: Star, title: 'Шуурхай мэдээ', text: 'Өдөр тутмын хамгийн сонирхолтой түүхүүдийг шууд.' },
          { icon: Users, title: 'Найдвартай эх сурвалж', text: 'Бид баталгаатай, хяналттай мэдээг л хүргэдэг.' },
          { icon: TrendingUp, title: 'Чиг хандлага', text: 'Загвар, үзэсгэлэн, амьдралын хамгийн шинэ трэнд.' },
        ].map(({ icon: Icon, title, text }) => (
          <div key={title} className="p-5 rounded-2xl border border-border bg-card">
            <div className="w-10 h-10 rounded-xl bg-brand-gradient text-white flex items-center justify-center">
              <Icon className="w-5 h-5" />
            </div>
            <h3 className="mt-3 font-black">{title}</h3>
            <p className="text-sm text-muted-foreground mt-1.5 leading-relaxed">{text}</p>
          </div>
        ))}
      </div>

      <div className="mt-12 prose prose-sm dark:prose-invert max-w-none">
        <h2 className="text-2xl font-black mt-10">Бидний үнэт зүйлс</h2>
        <p className="text-muted-foreground leading-relaxed">
          Үнэн, шуурхай, хариуцлагатай сэтгүүл зүй нь бидний үндсэн зарчим. Бид уншигчдынхаа
          цаг, итгэлийг хүндэтгэж, хувийн нууц, нэр төрд хүндэтгэлтэйгээр хандахыг эрхэмлэдэг.
        </p>
        <h2 className="text-2xl font-black mt-10">Холбоо барих</h2>
        <p className="text-muted-foreground leading-relaxed">
          Санал хүсэлт, мэдээлэл илгээх бол <a href="mailto:info@odod.mn" className="text-brand-pink font-semibold">info@odod.mn</a> хаягаар бидэнтэй холбогдоно уу.
        </p>
      </div>
    </div>
  );
}
