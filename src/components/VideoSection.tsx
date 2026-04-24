import { useQuery } from '@tanstack/react-query';
import { Play, Film } from 'lucide-react';
import { getArticles } from '@/services/api';
import { Link } from 'react-router-dom';

export default function VideoSection() {
  const { data } = useQuery({
    queryKey: ['video-articles'],
    queryFn: () => getArticles({ category: 'video', per_page: 6 }),
    staleTime: 5 * 60 * 1000,
  });

  const articles = data?.data ?? [];
  if (articles.length === 0) return null;

  const [lead, ...rest] = articles;

  return (
    <section className="mt-16">
      <div className="flex items-center justify-between mb-6">
        <div className="flex items-center gap-3">
          <span className="inline-flex items-center justify-center w-10 h-10 rounded-full bg-brand-gradient text-white">
            <Film className="w-5 h-5" />
          </span>
          <div>
            <h2 className="text-2xl font-black headline-display">Видео</h2>
            <p className="text-xs uppercase tracking-[0.2em] text-muted-foreground">
              Оддын хормуудыг бичлэгээр
            </p>
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-4">
        {/* Lead video — takes 2 cols */}
        <Link
          to={`/article/${lead.slug}`}
          className="group lg:col-span-2 relative aspect-video lg:aspect-auto rounded-2xl overflow-hidden bg-black"
        >
          <img
            src={lead.featured_image || '/ododnews/placeholder.jpg'}
            alt={lead.title}
            className="absolute inset-0 w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700"
          />
          <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent" />
          <div className="absolute inset-0 flex items-center justify-center">
            <div className="w-20 h-20 rounded-full bg-brand-gradient flex items-center justify-center ring-8 ring-white/15 group-hover:scale-110 transition-transform">
              <Play className="w-8 h-8 text-white fill-current ml-1" />
            </div>
          </div>
          <div className="absolute inset-x-0 bottom-0 p-6">
            <span className="inline-block text-[10px] font-black uppercase tracking-[0.2em] text-brand-gold mb-2">
              ★ Онцлох бичлэг
            </span>
            <h3 className="headline-display text-2xl md:text-3xl text-white text-shadow-pop line-clamp-3 max-w-2xl">
              {lead.title}
            </h3>
          </div>
        </Link>

        {/* Secondary video grid */}
        <div className="grid grid-cols-2 lg:grid-cols-1 gap-4">
          {rest.slice(0, 4).map((article) => (
            <Link
              key={article.id}
              to={`/article/${article.slug}`}
              className="group relative aspect-video rounded-xl overflow-hidden bg-black"
            >
              <img
                src={article.featured_image || '/ododnews/placeholder.jpg'}
                alt={article.title}
                className="absolute inset-0 w-full h-full object-cover opacity-85 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent" />
              <div className="absolute top-3 left-3 w-10 h-10 rounded-full bg-white/95 flex items-center justify-center">
                <Play className="w-4 h-4 text-black fill-current ml-0.5" />
              </div>
              <div className="absolute inset-x-0 bottom-0 p-3">
                <h4 className="text-sm font-bold text-white line-clamp-2 text-shadow-pop">
                  {article.title}
                </h4>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
}
