import React, { useEffect, useState } from 'react';
import { Layout } from '../components/layout/Layout';
import { Button } from '../components/ui/Button';
import { MissionCard } from '../components/ui/MissionCard';
import { TestimonialCard } from '../components/ui/TestimonialCard';
import { FeatureCard } from '../components/ui/FeatureCard';
import { ValueCard } from '../components/ui/ValueCard';
import { getPosts, Post } from '../services/wordpress';
import { RefreshCwIcon, UsersIcon, BrainIcon, HeartIcon, HandIcon, EyeIcon, BookOpenIcon, CalendarIcon } from 'lucide-react';
export function Home() {
  const [posts, setPosts] = useState<Post[]>([]);
  const [loading, setLoading] = useState(true);
  useEffect(() => {
    async function fetchPosts() {
      setLoading(true);
      const fetchedPosts = await getPosts(1, 3);
      setPosts(fetchedPosts);
      setLoading(false);
    }
    fetchPosts();
  }, []);
  return <Layout>
      {/* Hero Section */}
      <section className="relative bg-pattern-lines text-white py-20 lg:py-28 overflow-hidden">
        <div className="absolute inset-0 bg-gradient-to-r from-primary-blue to-secondary-burgundy opacity-95"></div>
        <div className="container mx-auto px-4 relative z-10">
          <div className="max-w-3xl mx-auto lg:mx-0">
            <div className="inline-block bg-primary-terracotta px-4 py-1 rounded-full text-sm font-medium mb-6">
              Welcome to Africa Center Hong Kong
            </div>
            <h1 className="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 font-heading">
              Rebranding <span className="text-primary-ochre">Blackness</span>{' '}
              in Asia
            </h1>
            <p className="text-xl mb-8 text-white/90">
              We are a platform & creative hub that fosters value-creating
              interactions between African and non-African communities in Asia
            </p>
            <div className="flex flex-wrap gap-4">
              <Button variant="ochre" size="large" className="shadow-lg">
                Explore Programs
              </Button>
              <Button variant="outline" size="large" className="border-white text-white hover:bg-white/10">
                Join Our Newsletter
              </Button>
            </div>
          </div>
        </div>
        {/* Decorative elements */}
        <div className="hidden lg:block absolute -right-16 -top-16 w-64 h-64 rounded-full bg-primary-terracotta opacity-20"></div>
        <div className="hidden lg:block absolute right-1/4 bottom-0 w-32 h-32 rounded-full bg-primary-ochre opacity-20"></div>
      </section>

      {/* Tagline Section */}
      <section className="py-10 bg-secondary-sand">
        <div className="container mx-auto px-4 text-center">
          <h2 className="text-2xl md:text-3xl font-bold text-primary-blue">
            African Solutions for Glocal Issues
          </h2>
        </div>
      </section>

      {/* Featured Programs */}
      <section className="py-16 bg-neutral-lightest">
        <div className="container mx-auto px-4">
          <div className="flex flex-col md:flex-row justify-between items-center mb-12">
            <div>
              <div className="inline-block bg-secondary-sand px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
                Discover
              </div>
              <h2 className="text-3xl font-bold text-primary-blue">
                Featured Programs
              </h2>
            </div>
            <Button variant="terracotta" className="mt-4 md:mt-0">
              View All Programs
            </Button>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <FeatureCard title="We have Moved" imageSrc="https://www.africacenterhk.com/wp-content/uploads/we-moved-1024x576.png" url="/directions" badge="New Location" />
            <FeatureCard title="Christmas Camp Open for Sign-up!" imageSrc="https://www.africacenterhk.com/wp-content/uploads/Afro-multi-activity-camp-summer-christmas-easter-1-1024x576.jpg" url="/afro-multi-activity-christmas-camp-2025" badge="For Kids" />
            <FeatureCard title="Newly Added Event for Art Lovers!" imageSrc="https://www.africacenterhk.com/wp-content/uploads/Cool-Africa-Craft-Crunch-1024x576.png" url="/events" badge="Art & Culture" />
            <FeatureCard title="Kids' Afterschool Activities" imageSrc="https://www.africacenterhk.com/wp-content/uploads/ACHK-Banner-Cool-Africa-Tots-Art-Playgroup-Junior-Art-Class.png" url="/cool-africa-programs" description="Creative and educational activities for children" />
            <FeatureCard title="Diversity, Equity & Inclusion Workshops" imageSrc="https://www.africacenterhk.com/wp-content/uploads/Team-Building-1-1-1-1024x688.jpeg" url="/diversity-equity-inclusion-workshop" description="Team building activities for organizations" />
            <FeatureCard title="Injera Night! Ethiopian Culinary Experience" imageSrc="https://www.africacenterhk.com/wp-content/uploads/1-33-1024x512.png" url="/ethiopian-eritrean-private-dinner" badge="Food & Culture" />
          </div>
        </div>
      </section>

      {/* Mission Section */}
      <section className="py-16 bg-pattern-dots">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <div className="inline-block bg-white px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
              Our Purpose
            </div>
            <h2 className="text-3xl font-bold mb-2 text-primary-blue">
              We work for a future where Africa has an equal footing
            </h2>
            <div className="w-24 h-1 bg-primary-ochre mx-auto"></div>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <MissionCard title="Rebranding Blackness" description="Blackness is often associated with danger and/or vulnerability, we challenge this perception and offer an opportunity to appreciate and benefit from accurate representations of blackness." url="https://themilsource.com/2021/12/03/how-africa-center-hong-kong-founder-and-ceo-innocent-mutanga-is-rebranding-africa/" iconElement={<RefreshCwIcon size={24} />} />
            <MissionCard title="Connecting Communities" description="We aim to become the biggest uniquely African platform in Asia to connect and build communities across ethnic groups, gender, socio-economic status, etc., and facilitate value-exchange between these communities." url="https://www.africacenterhk.com/2022/04/26/connecting-communities-april-2022%ef%bc%89/" iconElement={<UsersIcon size={24} />} />
            <MissionCard title="Black Consciousness" description="We champion an African perspective, especially the need for consciousness of the power dynamics rooted in colonialism and the need for self-love. We emphasize the value and need of an African perspective in today's uncertain world." url="https://www.africacenterhk.com/2021/10/19/our-hairstory-oct-2021/" iconElement={<BrainIcon size={24} />} />
          </div>
        </div>
      </section>

      {/* Values Section */}
      <section className="py-16 bg-white">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <div className="inline-block bg-secondary-sand px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
              What Guides Us
            </div>
            <h2 className="text-3xl font-bold text-primary-blue">Our Values</h2>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <ValueCard title="Diversity" description="We welcome and appreciate different perspectives" iconElement={<UsersIcon size={24} />} />
            <ValueCard title="Curiosity" description="We value curiosity and continuous learning" iconElement={<EyeIcon size={24} />} />
            <ValueCard title="Empathy" description="We encourage stepping into other's shoes and seeing the world through their eyes" iconElement={<HeartIcon size={24} />} />
            <ValueCard title="Dignity" description="We prioritize dignity in all our interactions" iconElement={<HandIcon size={24} />} />
          </div>
        </div>
      </section>

      {/* Photo Gallery Section */}
      <section className="py-16 bg-neutral-lightest">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <div className="inline-block bg-secondary-sand px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
              Visual Stories
            </div>
            <h2 className="text-3xl font-bold text-primary-blue">
              Photo Gallery
            </h2>
          </div>
          <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div className="overflow-hidden rounded-lg shadow-md group">
              <img src="https://www.africacenterhk.com/wp-content/uploads/Drum-Africa-Center-Hong-Kong.jpeg" alt="Africa Center Activities" className="w-full h-64 object-cover transition-transform group-hover:scale-105" />
            </div>
            <div className="overflow-hidden rounded-lg shadow-md group">
              <img src="https://www.africacenterhk.com/wp-content/uploads/WhatsApp-Image-2024-10-03-at-4.49.52-PM-1024x576.jpeg" alt="Africa Center Event" className="w-full h-64 object-cover transition-transform group-hover:scale-105" />
            </div>
            <div className="overflow-hidden rounded-lg shadow-md group">
              <img src="https://www.africacenterhk.com/wp-content/uploads/CKM-Tour-1024x692.png" alt="Chungking Mansions Tour" className="w-full h-64 object-cover transition-transform group-hover:scale-105" />
            </div>
            <div className="overflow-hidden rounded-lg shadow-md group">
              <img src="https://www.africacenterhk.com/wp-content/uploads/1-33-1024x512.png" alt="Ethiopian Culinary Experience" className="w-full h-64 object-cover transition-transform group-hover:scale-105" />
            </div>
          </div>
          <div className="text-center mt-8">
            <Button variant="outline">View More Photos</Button>
          </div>
        </div>
      </section>

      {/* Testimonials Section with background pattern */}
      <section className="py-16 bg-pattern-lines">
        <div className="container mx-auto px-4">
          <div className="text-center mb-12">
            <div className="inline-block bg-white px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
              What People Say
            </div>
            <h2 className="text-3xl font-bold text-primary-blue">
              Community Voices
            </h2>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <TestimonialCard quote="It is a fun and family-friendly space to find heartwarming African food and direct connection to the local African community. The center is for everyone, where they can freely express themselves and their ideas." name="Laura Akech" title="English Teacher" imageSrc="https://www.africacenterhk.com/wp-content/uploads/cropped-Screenshot-2023-01-05-at-11.41.18.png" />
            <TestimonialCard quote="The Africa Center is a turning point for the African communities within Hong Kong, and for those who wish to learn and integrate with the community not just within the city, but through out the African diaspora." name="Felix" title="Researcher" imageSrc="https://www.africacenterhk.com/wp-content/uploads/cropped-Screenshot-2023-01-05-at-11.41.23.png" />
            <TestimonialCard quote="I value the 'African Literature Book Club' as I value Women's Day and Black History Month because African literature deserves a spotlight." name="Daniela Lusan" title="Radio Show Host" imageSrc="https://www.africacenterhk.com/wp-content/uploads/2020/09/Daniela.png" />
          </div>
        </div>
      </section>

      {/* Upcoming Events Section */}
      <section className="py-16 bg-white">
        <div className="container mx-auto px-4">
          <div className="flex flex-col md:flex-row justify-between items-center mb-12">
            <div>
              <div className="inline-block bg-secondary-sand px-3 py-1 rounded-full text-sm font-medium text-primary-terracotta mb-2">
                Join Us
              </div>
              <h2 className="text-3xl font-bold text-primary-blue">
                Upcoming Events
              </h2>
            </div>
            <Button variant="terracotta" className="mt-4 md:mt-0">
              <CalendarIcon size={18} className="mr-2" />
              All Events
            </Button>
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div className="bg-white rounded-lg shadow-md overflow-hidden group hover:shadow-lg transition-shadow">
              <div className="p-4 bg-primary-blue text-white flex justify-between">
                <div>
                  <span className="text-2xl font-bold">15</span>
                  <span className="ml-1">Nov</span>
                </div>
                <div className="text-secondary-gold">6:00 PM - 8:00 PM</div>
              </div>
              <div className="p-6">
                <h3 className="text-xl font-bold mb-2 text-primary-blue group-hover:text-primary-terracotta transition-colors">
                  African Literature Book Club
                </h3>
                <p className="text-neutral-dark mb-4">
                  Join our monthly book discussion featuring contemporary
                  African authors.
                </p>
                <div className="flex items-center text-primary-terracotta font-medium">
                  <span>Learn More</span>
                  <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 ml-1 transform transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fillRule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clipRule="evenodd" />
                  </svg>
                </div>
              </div>
            </div>
            <div className="bg-white rounded-lg shadow-md overflow-hidden group hover:shadow-lg transition-shadow">
              <div className="p-4 bg-primary-blue text-white flex justify-between">
                <div>
                  <span className="text-2xl font-bold">22</span>
                  <span className="ml-1">Nov</span>
                </div>
                <div className="text-secondary-gold">2:00 PM - 5:00 PM</div>
              </div>
              <div className="p-6">
                <h3 className="text-xl font-bold mb-2 text-primary-blue group-hover:text-primary-terracotta transition-colors">
                  West African Drumming Workshop
                </h3>
                <p className="text-neutral-dark mb-4">
                  Learn traditional drumming techniques with our expert
                  instructors.
                </p>
                <div className="flex items-center text-primary-terracotta font-medium">
                  <span>Learn More</span>
                  <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 ml-1 transform transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fillRule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clipRule="evenodd" />
                  </svg>
                </div>
              </div>
            </div>
            <div className="bg-white rounded-lg shadow-md overflow-hidden group hover:shadow-lg transition-shadow">
              <div className="p-4 bg-primary-blue text-white flex justify-between">
                <div>
                  <span className="text-2xl font-bold">30</span>
                  <span className="ml-1">Nov</span>
                </div>
                <div className="text-secondary-gold">7:00 PM - 10:00 PM</div>
              </div>
              <div className="p-6">
                <h3 className="text-xl font-bold mb-2 text-primary-blue group-hover:text-primary-terracotta transition-colors">
                  Ethiopian Cuisine Night
                </h3>
                <p className="text-neutral-dark mb-4">
                  Experience authentic Ethiopian food and culture at our monthly
                  dinner.
                </p>
                <div className="flex items-center text-primary-terracotta font-medium">
                  <span>Learn More</span>
                  <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 ml-1 transform transition-transform group-hover:translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fillRule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clipRule="evenodd" />
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Newsletter Section */}
      <section className="py-16 bg-primary-blue relative overflow-hidden">
        <div className="absolute top-0 left-0 w-full h-1 bg-primary-ochre"></div>
        <div className="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-primary-terracotta opacity-10"></div>
        <div className="absolute left-1/4 -bottom-24 w-48 h-48 rounded-full bg-primary-ochre opacity-10"></div>
        <div className="container mx-auto px-4 relative z-10">
          <div className="max-w-2xl mx-auto text-center">
            <BookOpenIcon size={32} className="mx-auto mb-4 text-primary-ochre" />
            <h2 className="text-3xl font-bold mb-4 text-white">
              Stay Connected with Our Community
            </h2>
            <p className="mb-8 text-blue-100">
              Subscribe to our newsletter to receive updates on events,
              programs, and opportunities to get involved
            </p>
            <form className="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
              <input type="email" placeholder="Your email address" className="px-4 py-3 rounded-md flex-grow text-neutral-darkest focus:outline-none focus:ring-2 focus:ring-primary-ochre" />
              <Button variant="ochre" className="whitespace-nowrap">
                Subscribe
              </Button>
            </form>
            <p className="mt-6 text-sm text-blue-200">
              By subscribing, you agree to receive email communications from
              Africa Center Hong Kong.
            </p>
          </div>
        </div>
      </section>
    </Layout>;
}