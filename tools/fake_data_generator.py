import random
import uuid
import json

# -------------------------------------------------
# IMAGE URL (Picsum stable par produit)
# -------------------------------------------------
def generate_image_url(model_name):
    seed = model_name.replace(" ", "_")
    return f"https://picsum.photos/seed/{seed}/600/400"

# -------------------------------------------------
# UTILITIES
# -------------------------------------------------
def base_product(category, subcategory, brand, model, range_level, price):
    stock = random.randint(0, 100)
    return {
        "id": str(uuid.uuid4()),
        "category": category,
        "subcategory": subcategory,
        "brand": brand,
        "model": model,
        "range": range_level,
        "price": round(price, 2),
        "stock": stock,
        "rating": round(random.uniform(3.5, 5.0), 1),
        "reviews_count": random.randint(5, 2000),
        "is_available": stock > 0,
        "tags": [],
        "specs": {},
        "image_url": generate_image_url(model)
    }

# -------------------------------------------------
# GPU
# -------------------------------------------------
GPU_DB = {
    "RTX 4060": ("Entrée", 8, 300),
    "RTX 4070": ("Milieu", 12, 650),
    "RTX 4080": ("Premium", 16, 1200),
    "RTX 4090": ("Premium", 24, 1800),
    "RX 7600": ("Entrée", 8, 280),
    "RX 7900 XTX": ("Premium", 24, 1400),
}

def generate_gpu():
    model, data = random.choice(list(GPU_DB.items()))
    range_level, vram, base_price = data
    product = base_product(
        "Composants",
        "Carte graphique",
        "NVIDIA" if "RTX" in model else "AMD",
        model,
        range_level,
        base_price + random.randint(-50, 100)
    )
    product["specs"] = {
        "vram_gb": vram,
        "tdp_watts": random.randint(150, 450),
        "ray_tracing": "RTX" in model
    }
    product["tags"] = ["gaming", "4k"] if range_level == "Premium" else ["gaming"]
    return product

# -------------------------------------------------
# CPU
# -------------------------------------------------
def generate_cpu():
    cores = random.choice([4,6,8,12,16])
    range_level = "Entrée" if cores <= 6 else "Milieu" if cores <= 8 else "Premium"
    price = cores * random.randint(40,70)
    product = base_product(
        "Composants",
        "Processeur",
        random.choice(["Intel", "AMD"]),
        f"{cores} Cœurs {random.choice(['3.5GHz','4.0GHz','4.5GHz'])}",
        range_level,
        price
    )
    product["specs"] = {
        "cores": cores,
        "threads": cores*2,
        "base_clock_ghz": round(random.uniform(3.0,4.5),1)
    }
    product["tags"] = ["bureautique"] if range_level=="Entrée" else ["gaming"]
    return product

# -------------------------------------------------
# RAM
# -------------------------------------------------
def generate_ram():
    capacity = random.choice([8,16,32,64])
    freq = random.choice([2666,3200,3600,5200])
    type_ram = random.choice(["DDR4","DDR5"])
    range_level = "Entrée" if capacity<=16 else "Milieu" if capacity<=32 else "Premium"
    price = capacity*random.randint(5,15)
    product = base_product(
        "Composants",
        "Mémoire RAM",
        random.choice(["Corsair","G.Skill","Kingston"]),
        f"{capacity}Go {type_ram}",
        range_level,
        price
    )
    product["specs"] = {
        "capacity_gb": capacity,
        "frequency_mhz": freq,
        "type_ram": type_ram
    }
    product["tags"] = ["gaming"] if range_level!="Entrée" else ["bureautique"]
    return product

# -------------------------------------------------
# Stockage (SSD/HDD)
# -------------------------------------------------
def generate_storage():
    capacity = random.choice([256,512,1024,2048])
    type_storage = random.choice(["SATA","NVMe"])
    range_level = "Entrée" if type_storage=="SATA" else "Milieu" if capacity<=1024 else "Premium"
    price = capacity*0.08 if type_storage=="SATA" else capacity*0.12
    product = base_product(
        "Composants",
        "Stockage",
        random.choice(["Samsung","Crucial","Kingston"]),
        f"{capacity}Go {type_storage} SSD",
        range_level,
        price
    )
    product["specs"] = {
        "capacity_gb": capacity,
        "type": type_storage,
        "read_speed_mbps": random.randint(500,7000)
    }
    product["tags"] = ["rapide"] if type_storage=="NVMe" else ["standard"]
    return product

# -------------------------------------------------
# Écran
# -------------------------------------------------
def generate_monitor():
    size = random.choice([24,27,32])
    resolution = random.choice(["1920x1080","2560x1440","3840x2160"])
    if resolution=="3840x2160":
        range_level="Premium"
        price=random.randint(700,1200)
    elif resolution=="2560x1440":
        range_level="Milieu"
        price=random.randint(350,600)
    else:
        range_level="Entrée"
        price=random.randint(150,300)
    product = base_product(
        "Écrans",
        random.choice(["Gaming","Bureautique","4K"]),
        random.choice(["Samsung","LG","ASUS"]),
        f"{size}\" {resolution}",
        range_level,
        price
    )
    product["specs"] = {
        "screen_size_inches": size,
        "resolution": resolution,
        "refresh_rate_hz": random.choice([60,144,165,240]),
        "panel_type": random.choice(["IPS","VA"])
    }
    product["tags"] = ["gaming"] if range_level!="Entrée" else ["bureautique"]
    return product

# -------------------------------------------------
# Accessoires
# -------------------------------------------------
def generate_accessory(subcategory):
    name_map = {
        "Housse":"Housse 15\"",
        "Support":"Support écran",
        "Câble":"HDMI 2m"
    }
    product = base_product(
        "Accessoires",
        subcategory,
        random.choice(["Anker","UGREEN","Belkin"]),
        name_map.get(subcategory, "Accessoire"),
        "Entrée",
        random.randint(10,60)
    )
    # Specs spécifiques selon sous-catégorie
    if subcategory=="Housse":
        product["specs"] = {"compatibilite":"Universelle","dimensions":"30x20x2 cm"}
    elif subcategory=="Support":
        product["specs"] = {"compatibilite":"Universelle","material":"Aluminium","max_weight_kg":10}
    elif subcategory=="Câble":
        product["specs"] = {"compatibilite":"Universelle","length_m":2,"type_connection":"HDMI"}
    product["tags"] = ["accessoire"]
    return product

# -------------------------------------------------
# DATASET
# -------------------------------------------------
GENERATORS = [
    generate_gpu,
    generate_cpu,
    generate_ram,
    generate_storage,
    generate_monitor,
    lambda: generate_accessory("Housse"),
    lambda: generate_accessory("Support"),
    lambda: generate_accessory("Câble")
]

def generate_dataset(total=1000):
    return [random.choice(GENERATORS)() for _ in range(total)]

# -------------------------------------------------
# MAIN
# -------------------------------------------------
if __name__ == "__main__":
    data = generate_dataset(1000)
    with open("data/catalog.json","w",encoding="utf-8") as f:
        json.dump(data,f,indent=4,ensure_ascii=False)
    print("✅ Dataset généré.")
