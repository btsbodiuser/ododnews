import { Link } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import { Mail, Phone, MapPin } from 'lucide-react';
import { getMenuCategories, getFooterLinks } from '@/services/api';
import Logo from '@/components/Logo';

export default function Footer() {
  const { data: categories = [] } = useQuery({
    queryKey: ['menu-categories'],
    queryFn: getMenuCategories,
    staleTime: 5 * 60 * 1000,
  });

  const { data: footerLinks = [] } = useQuery({
    queryKey: ['footer-links'],
    queryFn: getFooterLinks,
    staleTime: 10 * 60 * 1000,
  });

  return (
    <footer className="bg-black text-gray-300 mt-auto relative overflow-hidden">
      <div className="absolute inset-x-0 top-0 h-1 bg-brand-gradient" />
      <div className="max-w-7xl mx-auto px-4 py-14">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
          {/* Brand */}
          <div>
            <Link to="/" className="inline-block">
              <Logo variant="white" size="lg" />
            </Link>
            <p className="mt-4 text-sm leading-relaxed text-gray-400">
              Оддын амьдрал, загвар, цуурхлыг хамгийн эхэнд. Бид танд өдөр бүр
              хамгийн халуун мэдээг найдвартайгаар хүргэнэ.
            </p>
            <div className="flex gap-2 mt-5">
              {['Instagram', 'Facebook', 'YouTube', 'TikTok'].map((name) => (
                <a
                  key={name}
                  href="#"
                  aria-label={name}
                  className="h-9 px-3 rounded-full bg-white/5 hover:bg-brand-gradient hover:text-white flex items-center justify-center transition-all text-[10px] font-black tracking-widest"
                >
                  {name.slice(0, 2).toUpperCase()}
                </a>
              ))}
            </div>
          </div>

          {/* Top categories — from backend */}
          <div>
            <h3 className="text-white font-black uppercase tracking-[0.18em] text-xs mb-4">
              Шилдэг ангилал
            </h3>
            <ul className="space-y-2.5 text-sm">
              {categories.slice(0, 6).map((cat) => (
                <li key={cat.id}>
                  <Link
                    to={`/category/${cat.slug}`}
                    className="hover:text-brand-pink transition-colors inline-flex items-center gap-2 group"
                  >
                    <span
                      className="w-1.5 h-1.5 rounded-full group-hover:scale-125 transition-transform"
                      style={{ backgroundColor: cat.color || 'var(--brand-pink)' }}
                    />
                    {cat.name}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Links — controlled from backend (falls back to static routes) */}
          <div>
            <h3 className="text-white font-black uppercase tracking-[0.18em] text-xs mb-4">
              Холбоос
            </h3>
            <ul className="space-y-2.5 text-sm">
              {footerLinks.map((link) => (
                <li key={`${link.label}-${link.url}`}>
                  {link.external ? (
                    <a
                      href={link.url}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="hover:text-brand-pink transition-colors"
                    >
                      {link.label}
                    </a>
                  ) : (
                    <Link
                      to={link.url}
                      className="hover:text-brand-pink transition-colors"
                    >
                      {link.label}
                    </Link>
                  )}
                </li>
              ))}
            </ul>
          </div>

          {/* Contact */}
          <div>
            <h3 className="text-white font-black uppercase tracking-[0.18em] text-xs mb-4">
              Холбоо барих
            </h3>
            <ul className="space-y-3 text-sm">
              <li>
                <a
                  href="mailto:info@odod.mn"
                  className="flex items-center gap-2.5 hover:text-brand-pink transition-colors"
                >
                  <Mail className="w-4 h-4 text-brand-pink" />
                  info@odod.mn
                </a>
              </li>
              <li>
                <a
                  href="tel:+97670000000"
                  className="flex items-center gap-2.5 hover:text-brand-pink transition-colors"
                >
                  <Phone className="w-4 h-4 text-brand-pink" />
                  +976 7000-0000
                </a>
              </li>
              <li className="flex items-start gap-2.5">
                <MapPin className="w-4 h-4 text-brand-pink mt-0.5 shrink-0" />
                Улаанбаатар хот, Сүхбаатар дүүрэг
              </li>
              <li>
                <Link
                  to="/contact"
                  className="inline-flex items-center gap-1.5 mt-1 px-3 py-1.5 rounded-full bg-brand-gradient text-white text-xs font-bold hover:opacity-90 transition-opacity"
                >
                  Бидэнтэй холбогдох →
                </Link>
              </li>
            </ul>
          </div>
        </div>

        <div className="border-t border-white/10 mt-12 pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-500">
          <span>© {new Date().getFullYear()} ODOD STARS · NEWS. Бүх эрх хуулиар хамгаалагдсан.</span>
          <span className="uppercase tracking-[0.2em]">Made with ★ in Ulaanbaatar</span>
        </div>
      </div>
    </footer>
  );
}
