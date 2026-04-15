import { Skeleton } from '@/components/ui/skeleton';

export function ArticleCardSkeleton() {
  return (
    <div>
      <Skeleton className="aspect-[16/10] rounded-xl" />
      <Skeleton className="h-3 w-16 mt-3" />
      <Skeleton className="h-5 w-full mt-2" />
      <Skeleton className="h-5 w-3/4 mt-1" />
      <Skeleton className="h-3 w-1/2 mt-2" />
    </div>
  );
}

export function ArticleHorizontalSkeleton() {
  return (
    <div className="flex gap-4">
      <Skeleton className="w-36 h-24 rounded-xl shrink-0" />
      <div className="flex-1">
        <Skeleton className="h-3 w-16" />
        <Skeleton className="h-4 w-full mt-2" />
        <Skeleton className="h-4 w-3/4 mt-1" />
        <Skeleton className="h-3 w-1/3 mt-2" />
      </div>
    </div>
  );
}

export function FeaturedSkeleton() {
  return <Skeleton className="aspect-[21/9] rounded-2xl" />;
}
