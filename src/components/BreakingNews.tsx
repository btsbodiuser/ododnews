import { useQuery } from '@tanstack/react-query';
import { Flame } from 'lucide-react';
import { Link } from 'react-router-dom';
import { getBreakingArticles } from '@/services/api';

export default function BreakingNews() {
  const { data: articles = [] } = useQuery({
    queryKey: ['breaking-articles'],
    queryFn: getBreakingArticles,
    staleTime: 60 * 1000,
  });

  if (articles.length === 0) return null;

  const loop = [...articles, ...articles, ...articles];

  return (
    <div className="bg-black text-white overflow-hidden">
      <div className="flex items-stretch">
        {/* Label */}
        <div className="bg-brand-gradient px-3 md:px-5 py-2 flex items-center gap-1.5 shrink-0 relative z-10">
          <Flame className="w-4 h-4 fill-current animate-hot-pulse" />
          <span className="text-xs md:text-sm font-black uppercase tracking-[0.18em]">
            Яг одоо
          </span>
        </div>

        {/* Scrolling tape */}
        <div
          className="flex-1 overflow-hidden relative"
          style={{
            maskImage: 'linear-gradient(90deg, transparent 0, #000 4%, #000 96%, transparent 100%)',
            WebkitMaskImage: 'linear-gradient(90deg, transparent 0, #000 4%, #000 96%, transparent 100%)',
          }}
        >
          <div className="flex gap-8 whitespace-nowrap py-2 animate-marquee">
            {loop.map((article, i) => (
              <Link
                key={`${article.id}-${i}`}
                to={`/article/${article.slug}`}
                className="text-sm inline-flex items-center gap-3 hover:text-brand-gold transition-colors"
              >
                <span className="text-brand-gold">✦</span>
                <span className="font-medium">{article.title}</span>
              </Link>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
}
