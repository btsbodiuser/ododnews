import { useQuery } from '@tanstack/react-query';
import { Link } from 'react-router-dom';
import { ChevronRight } from 'lucide-react';
import { getArticlesByCategory } from '@/services/api';
import ArticleCard from './ArticleCard';
import type { Category } from '@/types';

interface Props {
  category: Category;
}

export default function CategoryRail({ category }: Props) {
  const { data } = useQuery({
    queryKey: ['category-rail', category.slug],
    queryFn: () => getArticlesByCategory(category.slug, 1),
    staleTime: 3 * 60 * 1000,
  });

  const articles = data?.data ?? [];
  if (articles.length === 0) return null;

  const accent = category.color || 'var(--brand-pink)';

  return (
    <section className="mt-12">
      <div className="flex items-end justify-between mb-5">
        <div className="flex items-center gap-3">
          <span
            className="inline-block w-1.5 h-8 rounded-full"
            style={{ backgroundColor: accent }}
          />
          <div>
            <h2 className="text-2xl md:text-3xl font-black headline-display">
              {category.name}
            </h2>
            {category.description && (
              <p className="text-xs uppercase tracking-[0.2em] text-muted-foreground mt-0.5">
                {category.description}
              </p>
            )}
          </div>
        </div>
        <Link
          to={`/category/${category.slug}`}
          className="text-sm font-bold inline-flex items-center gap-1 hover:text-brand-pink transition-colors"
        >
          Бүгдийг үзэх
          <ChevronRight className="w-4 h-4" />
        </Link>
      </div>

      <div className="flex gap-4 overflow-x-auto scrollbar-hide -mx-4 px-4 pb-2 snap-x snap-mandatory">
        {articles.slice(0, 8).map((article) => (
          <div key={article.id} className="snap-start">
            <ArticleCard article={article} variant="compact" />
          </div>
        ))}
      </div>
    </section>
  );
}
