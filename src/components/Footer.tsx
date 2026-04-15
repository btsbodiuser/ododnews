import { Link } from 'react-router-dom';
import { useQuery } from '@tanstack/react-query';
import { getMenuCategories } from '@/services/api';

export default function Footer() {
  const { data: categories = [] } = useQuery({
    queryKey: ['menu-categories'],
    queryFn: getMenuCategories,
    staleTime: 5 * 60 * 1000,
  });

  return (
    <footer className="bg-gray-950 text-gray-400 mt-auto">
      <div className="max-w-7xl mx-auto px-4 py-12">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          {/* Brand */}
          <div>
            <Link to="/" className="text-2xl font-black text-white">
              <span className="text-red-600">ODOD</span>
              <span className="text-gray-500 text-sm font-medium ml-1">МЭДЭЭ</span>
            </Link>
            <p className="mt-4 text-sm leading-relaxed">
              Монголын хамгийн шинэ, найдвартай мэдээллийн эх сурвалж. Бид танд чанартай, бодит мэдээллийг хүргэнэ.
            </p>
          </div>

          {/* Categories */}
          <div>
            <h3 className="text-white font-semibold mb-4">Ангилал</h3>
            <ul className="space-y-2 text-sm">
              {categories.slice(0, 6).map((cat) => (
                <li key={cat.id}>
                  <Link
                    to={`/category/${cat.slug}`}
                    className="hover:text-white transition-colors"
                  >
                    {cat.name}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Links */}
          <div>
            <h3 className="text-white font-semibold mb-4">Холбоос</h3>
            <ul className="space-y-2 text-sm">
              <li><Link to="/" className="hover:text-white transition-colors">Нүүр</Link></li>
              <li><Link to="/search" className="hover:text-white transition-colors">Хайлт</Link></li>
              <li><a href="#" className="hover:text-white transition-colors">Бидний тухай</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Холбоо барих</a></li>
              <li><a href="#" className="hover:text-white transition-colors">Зар сурталчилгаа</a></li>
            </ul>
          </div>

          {/* Contact */}
          <div>
            <h3 className="text-white font-semibold mb-4">Холбоо барих</h3>
            <ul className="space-y-2 text-sm">
              <li>📧 info@odod.mn</li>
              <li>📞 +976 7000-0000</li>
              <li>📍 Улаанбаатар хот, Сүхбаатар дүүрэг</li>
            </ul>
            <div className="flex gap-3 mt-4">
              <a href="#" className="w-9 h-9 bg-gray-800 rounded-full flex items-center justify-center hover:bg-gray-700 transition-colors text-gray-400 hover:text-white">
                <span className="text-sm">f</span>
              </a>
              <a href="#" className="w-9 h-9 bg-gray-800 rounded-full flex items-center justify-center hover:bg-gray-700 transition-colors text-gray-400 hover:text-white">
                <span className="text-sm">𝕏</span>
              </a>
              <a href="#" className="w-9 h-9 bg-gray-800 rounded-full flex items-center justify-center hover:bg-gray-700 transition-colors text-gray-400 hover:text-white">
                <span className="text-sm">in</span>
              </a>
            </div>
          </div>
        </div>

        <div className="border-t border-gray-800 mt-10 pt-6 text-center text-xs text-gray-500">
          © {new Date().getFullYear()} ODOD МЭДЭЭ. Бүх эрх хуулиар хамгаалагдсан.
        </div>
      </div>
    </footer>
  );
}
