import { useState } from 'react';
import { motion } from 'framer-motion';
import { Mail, Phone, MapPin, Send, MessageCircle } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';

export default function Contact() {
  const [sent, setSent] = useState(false);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setSent(true);
  };

  return (
    <div className="max-w-6xl mx-auto px-4 py-12 lg:py-16">
      <motion.div
        initial={{ opacity: 0, y: 16 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.4 }}
      >
        <div className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-gradient text-white text-[11px] font-black uppercase tracking-[0.18em]">
          <MessageCircle className="w-3.5 h-3.5" /> Холбоо барих
        </div>
        <h1 className="mt-4 text-4xl lg:text-5xl font-black leading-tight">
          Бидэнтэй <span className="bg-brand-gradient bg-clip-text text-transparent">холбогдоорой</span>
        </h1>
        <p className="mt-4 text-lg text-muted-foreground max-w-2xl">
          Мэдээ, санал хүсэлт, хамтын ажиллагааны саналаа доорх маягтаар эсвэл
          харилцах хэрэгслээр илгээнэ үү.
        </p>
      </motion.div>

      <div className="grid lg:grid-cols-5 gap-8 mt-12">
        <div className="lg:col-span-2 space-y-4">
          {[
            { icon: Mail, label: 'Имэйл', value: 'info@odod.mn', href: 'mailto:info@odod.mn' },
            { icon: Phone, label: 'Утас', value: '+976 7000-0000', href: 'tel:+97670000000' },
            { icon: MapPin, label: 'Хаяг', value: 'Улаанбаатар хот, Сүхбаатар дүүрэг' },
          ].map(({ icon: Icon, label, value, href }) => {
            const Body = (
              <div className="flex items-start gap-4 p-5 rounded-2xl border border-border bg-card hover:border-brand-pink/40 transition-colors">
                <div className="w-11 h-11 rounded-xl bg-brand-gradient text-white flex items-center justify-center shrink-0">
                  <Icon className="w-5 h-5" />
                </div>
                <div>
                  <p className="text-[11px] font-black uppercase tracking-[0.18em] text-muted-foreground">{label}</p>
                  <p className="mt-1 font-semibold">{value}</p>
                </div>
              </div>
            );
            return href ? (
              <a key={label} href={href}>{Body}</a>
            ) : (
              <div key={label}>{Body}</div>
            );
          })}
        </div>

        <form
          onSubmit={handleSubmit}
          className="lg:col-span-3 p-6 rounded-2xl border border-border bg-card space-y-4"
        >
          <div className="grid sm:grid-cols-2 gap-4">
            <div>
              <label className="text-xs font-black uppercase tracking-wider text-muted-foreground">Нэр</label>
              <Input required className="mt-1.5" placeholder="Таны нэр" />
            </div>
            <div>
              <label className="text-xs font-black uppercase tracking-wider text-muted-foreground">Имэйл</label>
              <Input required type="email" className="mt-1.5" placeholder="you@example.com" />
            </div>
          </div>
          <div>
            <label className="text-xs font-black uppercase tracking-wider text-muted-foreground">Сэдэв</label>
            <Input className="mt-1.5" placeholder="Юуны тухай?" />
          </div>
          <div>
            <label className="text-xs font-black uppercase tracking-wider text-muted-foreground">Мессеж</label>
            <textarea
              required
              rows={5}
              placeholder="Мессежээ бичнэ үү..."
              className="mt-1.5 w-full rounded-md border border-input bg-background px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring resize-none"
            />
          </div>
          <Button
            type="submit"
            disabled={sent}
            className="w-full rounded-full bg-brand-gradient text-white border-0 h-11 font-bold"
          >
            <Send className="w-4 h-4 mr-2" />
            {sent ? 'Илгээгдлээ — баярлалаа!' : 'Илгээх'}
          </Button>
        </form>
      </div>
    </div>
  );
}
