import React, { useRef, useMemo, useState, useEffect } from 'react';
import { Canvas, useFrame } from '@react-three/fiber';
import { useScroll, useTransform, motion } from 'framer-motion';
import { Float, Environment, ContactShadows, PresentationControls, useCursor } from '@react-three/drei';
import * as THREE from 'three';

// Fixed: Add missing intrinsic elements for R3F to JSX namespace
declare global {
  namespace JSX {
    interface IntrinsicElements {
      group: any;
      mesh: any;
      boxGeometry: any;
      meshStandardMaterial: any;
      planeGeometry: any;
      ambientLight: any;
      spotLight: any;
    }
  }
}

// --- 3D Components ---

const LuxuryBookModel = ({ rotationY }: { rotationY: number }) => {
    const groupRef = useRef<THREE.Group>(null);
    const coverRef = useRef<THREE.Group>(null);
    const [isOpen, setIsOpen] = useState(false);
    const [hovered, setHover] = useState(false);
    
    // Change cursor to pointer when hovering the book
    useCursor(hovered);

    useFrame((state, delta) => {
        if (groupRef.current) {
            // Apply scroll-based rotation as a base movement
            // using lerp for smooth transitions
            groupRef.current.rotation.y = THREE.MathUtils.lerp(groupRef.current.rotation.y, rotationY, 0.1);
        }

        if (coverRef.current) {
            // Animate cover opening smoothly
            const targetRotation = isOpen ? -Math.PI * 0.85 : 0;
            // Use a spring-like lerp for the cover
            coverRef.current.rotation.y = THREE.MathUtils.lerp(coverRef.current.rotation.y, targetRotation, delta * 3);
        }
    });

    const handlePointerOver = (e: any) => {
        e.stopPropagation();
        setHover(true);
    };
    
    const handlePointerOut = (e: any) => {
        e.stopPropagation();
        setHover(false);
    }

    const handleClick = (e: any) => {
        e.stopPropagation();
        setIsOpen(!isOpen);
    }

    // Dimensions
    const width = 3;
    const height = 4.2;
    const thick = 0.5;
    const coverThick = 0.08;
    const pageThick = thick - (2 * coverThick);

    return (
        <group 
            ref={groupRef} 
            rotation={[0.2, 0, 0]}
            onPointerOver={handlePointerOver}
            onPointerOut={handlePointerOut}
            onClick={handleClick}
        >
            {/* --- Static Part: Back Cover, Spine, Pages --- */}
            
            {/* Back Cover */}
            <mesh position={[0, 0, -thick/2 + coverThick/2]} castShadow receiveShadow>
                <boxGeometry args={[width, height, coverThick]} />
                <meshStandardMaterial color="#1f2937" roughness={0.2} metalness={0.1} />
            </mesh>

            {/* Spine */}
            <mesh position={[-width/2, 0, 0]} castShadow receiveShadow>
                <boxGeometry args={[coverThick, height, thick]} />
                <meshStandardMaterial color="#fbbf24" metalness={0.6} roughness={0.3} />
            </mesh>

            {/* Pages Block */}
            <mesh position={[0, 0, 0]} castShadow>
                <boxGeometry args={[width - 0.2, height - 0.2, pageThick]} />
                <meshStandardMaterial color="#fdfbf7" roughness={0.9} />
            </mesh>

            {/* --- Dynamic Part: Front Cover (Hinged) --- */}
            {/* Pivot Point Group: Located at the spine edge */}
            <group 
                ref={coverRef} 
                position={[-width/2, 0, thick/2 - coverThick/2]}
            >
                {/* The visual cover, offset so its edge aligns with the pivot */}
                <group position={[width/2, 0, 0]}>
                    <mesh castShadow receiveShadow>
                        <boxGeometry args={[width, height, coverThick]} />
                        <meshStandardMaterial color="#1f2937" roughness={0.2} metalness={0.1} />
                    </mesh>

                    {/* Embossed Gold Title */}
                    <mesh position={[0, 1, coverThick/2 + 0.005]}>
                        <boxGeometry args={[1.8, 0.4, 0.01]} />
                        <meshStandardMaterial color="#fbbf24" metalness={0.8} roughness={0.2} />
                    </mesh>

                    {/* Embossed Decorative Element */}
                    <mesh position={[0, -0.5, coverThick/2 + 0.005]}>
                        <planeGeometry args={[1, 1]}/>
                        <meshStandardMaterial color="#111827" roughness={0.5} />
                    </mesh>
                    
                    {/* Inner Cover Paper (White) */}
                    <mesh position={[0, 0, -coverThick/2 - 0.001]} rotation={[0, Math.PI, 0]}>
                        <planeGeometry args={[width - 0.1, height - 0.1]} />
                        <meshStandardMaterial color="#f5f5f5" />
                    </mesh>
                </group>
            </group>
        </group>
    );
};

// --- Main Component ---

const features = [
    { id: 1, title: "Premium Paper", desc: "120gsm Munken Lynx", side: 'left', top: '20%' },
    { id: 2, title: "Hand-Bound", desc: "Crafted in Italy", side: 'left', top: '50%' },
    { id: 3, title: "Gold Foil", desc: "24k Gold Accents", side: 'right', top: '30%' },
    { id: 4, title: "Limited Edition", desc: "Only 500 copies", side: 'right', top: '70%' },
];

const BookShowcase: React.FC = () => {
    const containerRef = useRef<HTMLDivElement>(null);
    const [isMobile, setIsMobile] = useState(() => typeof window !== 'undefined' ? window.innerWidth < 768 : false);

    useEffect(() => {
        const handleResize = () => {
            setIsMobile(window.innerWidth < 768);
        };
        
        window.addEventListener('resize', handleResize);
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    const { scrollYProgress } = useScroll({
        target: containerRef,
        offset: ["start end", "end start"]
    });
    
    // Parallax background
    const yBg = useTransform(scrollYProgress, [0, 1], ["0%", "20%"]);
    
    // Map scroll to rotation
    const [rotationY, setRotationY] = useState(0);

    useMemo(() => {
        return scrollYProgress.on("change", (v) => {
            // Full rotation over the scroll distance
            setRotationY(v * Math.PI * 2);
        });
    }, [scrollYProgress]);

    return (
        <div ref={containerRef} className="relative w-full h-[120vh] bg-gray-100 overflow-hidden mb-20 flex items-center justify-center">
            
            {/* Parallax Background Pattern */}
            <motion.div 
                style={{ y: yBg }}
                className="absolute inset-0 opacity-[0.03] pointer-events-none"
            >
                <div className="w-full h-full" style={{ 
                    backgroundImage: 'radial-gradient(#000 1px, transparent 1px)', 
                    backgroundSize: '40px 40px' 
                }}></div>
            </motion.div>

            {/* Text Snippets - Hidden on mobile for cleaner look */}
            <div className="absolute inset-0 max-w-7xl mx-auto px-6 lg:px-8 pointer-events-none z-10">
                <div className="relative w-full h-full">
                    {features.map((feature, i) => (
                        <motion.div
                            key={feature.id}
                            initial={{ opacity: 0, x: feature.side === 'left' ? -50 : 50 }}
                            whileInView={{ opacity: 1, x: 0 }}
                            transition={{ duration: 0.8, delay: i * 0.2 }}
                            className={`absolute hidden md:block ${feature.side === 'left' ? 'left-0 md:left-20 text-right' : 'right-0 md:right-20 text-left'} w-48`}
                            style={{ top: feature.top }}
                        >
                            <h4 className="serif text-xl text-gray-900">{feature.title}</h4>
                            <p className="text-xs uppercase tracking-widest text-gray-500 mt-1">{feature.desc}</p>
                            
                            <div className={`absolute top-1/2 ${feature.side === 'left' ? '-right-16' : '-left-16'} w-12 h-[1px] bg-gray-300 hidden md:block`}></div>
                        </motion.div>
                    ))}
                    
                    {/* Center Title */}
                    <div className="absolute top-10 left-0 right-0 text-center">
                         <span className="text-xs font-bold uppercase tracking-[0.3em] text-gray-400">The Collection</span>
                         <h2 className="text-3xl md:text-5xl serif text-gray-900 mt-2">Craftsmanship</h2>
                         <p className="mt-4 text-xs text-gray-500 font-mono block">( Click to Open • Drag to Rotate )</p>
                    </div>
                </div>
            </div>

            {/* 3D Scene */}
            <div className="w-full h-full z-20 cursor-grab active:cursor-grabbing">
                <Canvas 
                    shadows 
                    dpr={[1, 2]}
                    camera={{ position: [0, 0, isMobile ? 12 : 8], fov: 35 }}
                    key={isMobile ? 'mobile' : 'desktop'} // Force remount on view change for clean camera reset
                >
                    <ambientLight intensity={0.6} />
                    <spotLight position={[10, 10, 10]} angle={0.15} penumbra={1} shadow-mapSize={2048} castShadow intensity={1.5} />
                    <Environment preset="city" />
                    
                    <PresentationControls
                        global={false}
                        cursor={true}
                        snap={false}
                        speed={1.5}
                        zoom={isMobile ? 0.6 : 0.8}
                        rotation={[0, 0, 0]}
                        polar={isMobile ? [-0.2, 0.2] : [-0.4, 0.4]}
                        azimuth={[-Infinity, Infinity]}
                    >
                        <Float speed={2} rotationIntensity={0.2} floatIntensity={0.5}>
                            <group scale={isMobile ? 0.9 : 1}>
                                <LuxuryBookModel rotationY={rotationY} />
                            </group>
                        </Float>
                    </PresentationControls>

                    <ContactShadows position={[0, -2.5, 0]} opacity={0.4} scale={10} blur={2.5} far={4} />
                </Canvas>
            </div>
            
            {/* Overlay Gradient for smooth blending */}
            <div className="absolute bottom-0 w-full h-32 bg-gradient-to-t from-[#fcfcfc] to-transparent pointer-events-none z-10"></div>
            <div className="absolute top-0 w-full h-32 bg-gradient-to-b from-[#fcfcfc] to-transparent pointer-events-none z-10"></div>
        </div>
    );
};

export default BookShowcase;